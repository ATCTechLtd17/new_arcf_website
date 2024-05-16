<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\CustomerAdvance;
use App\Models\CustomerAdvanceType;
use App\Models\DrawerCash;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceDuePayment;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if ($request->boolean('is_print')){
            $fromDate = $request->get('from_date');
            $toDate = $request->get('to_date');

            $type = authUser()->service_type;

            $invoicesQuery = Invoice::query()
                ->where('type', $type);

            $suppliersQuery = Supplier::query()
                ->where('type', $type);

            $expenses = Expense::query()
                ->where('type', $type);

            $supplierExpenses = Expense::query()
                ->where('type', $type)
                ->whereNotNull('supplier_id');

            $agentExpenses = Expense::query()
                ->where('type', $type)
                ->whereNotNull('agent_id');

            $invoicesIds = Invoice::query()
                ->where('type', $type)
                ->pluck('id');

            $payments = InvoiceDuePayment::query()
                ->with(['invoice'])
                ->whereIn('invoice_id', $invoicesIds);

            $customerAdvanceIds = CustomerAdvance::query()
                ->where('service_type', authUserServiceType())
                ->pluck('id');
            $customerAdvanceTypes = CustomerAdvanceType::query()
                ->whereHas('advances', static function ($query) use ($customerAdvanceIds) {
                    $query->whereIn('id', $customerAdvanceIds);
                });

            if ($fromDate) {
                $invoicesQuery->whereDate('issue_date', '>=', $fromDate);
                $expenses->whereDate('created_at', '>=', $fromDate);
                $supplierExpenses->whereDate('created_at', '>=', $fromDate);
                $agentExpenses->whereDate('created_at', '>=', $fromDate);
                $payments->whereDate('date', '>=', $fromDate);
                $suppliersQuery->whereDate('created_at', '>=', $fromDate);
            }

            if ($toDate) {
                $invoicesQuery->whereDate('issue_date', '<=', $toDate);
                $expenses->whereDate('created_at', '<=', $toDate);
                $supplierExpenses->whereDate('created_at', '<=', $toDate);
                $agentExpenses->whereDate('created_at', '<=', $toDate);
                $payments->whereDate('date', '<=', $toDate);
                $suppliersQuery->whereDate('created_at', '<=', $toDate);
            }

            $invoices = $invoicesQuery->get();
            $totalInvoiceAmount = $invoices->sum('total_amount');
            $totalInvoicePaidAmount = $invoices->sum('total_paid_amount');

            $totalInvoiceBalance = $invoices->sum('total_balance');

            $suppliers = $suppliersQuery->get();
            $totalSupplierCredit = $suppliers->sum('credit');
            $totalSupplierBalance = $suppliers->sum('balance');
            $totalSupplierDepositAmount = $suppliers->sum('total_deposit_amount');

            $expenses = $expenses
                ->latest()
                ->get();

            $totalExpenseAmount = $expenses->sum('total_amount');

            $supplierExpenses = $supplierExpenses
                ->latest()
                ->take(5)
                ->get();

            $totalSupplierExpenseAmount = $supplierExpenses->sum('total_amount');

            $agentExpenses = $agentExpenses
                ->latest()
                ->take(5)
                ->get();

            $totalAgentExpenseAmount = $agentExpenses->sum('total_amount');

            $banks = Bank::where('type', authUser()->service_type)->get();

            $drawerCashInAmount = DrawerCash::query()
                ->where('type', authUser()->service_type)
                ->sum('in_amount');

            $drawerCashOutAmount = DrawerCash::query()
                ->where('type', authUser()->service_type)
                ->sum('out_amount');

            $customerAdvanceTypes = $customerAdvanceTypes->get();

            $suppliersTotalDeposit = 0;
            $suppliersTotalInvoiceTotal = 0;
            $suppliersTotalBalance = 0;
            $suppliersTotalCredit = 0;
            foreach ($suppliers as $supplier){
                $suppliersTotalDeposit+=$supplier->total_deposit_amount;
                $suppliersTotalInvoiceTotal+=$supplier->total_invoice_rate_amount;
                $suppliersTotalBalance+=$supplier->balance;
                if($supplier->total_deposit_amount < $supplier->total_invoice_amount){
                    $suppliersTotalCredit+=$supplier->balance;
                }
            }

            $salesDetails = [
              'invoice_total' => money_format($totalInvoiceAmount),
              'paid' => money_format($totalInvoicePaidAmount),
              'customer_due' => money_format($totalInvoiceAmount-$totalInvoicePaidAmount),
              'credit' => money_format($totalSupplierCredit, 2),
              'topUpAmount' => money_format($totalSupplierDepositAmount, 2),
              'supplier_deposit_balance' => money_format($totalSupplierBalance, 2),
            ];

            $supplierPaymentDetails = [
                'total_deposit' => money_format($suppliersTotalDeposit),
                'invoice_total' => money_format($suppliersTotalInvoiceTotal),
                'total_balance' => money_format($suppliersTotalBalance),
                'total_credit' => money_format($suppliersTotalCredit, 2),
            ];

            $incomeVsExpense = [
                'invoice_profit' => money_format($totalInvoiceBalance, 2),
                'total_expense' => money_format($totalExpenseAmount),
                'total_profit' => money_format($totalExpenseAmount-$totalInvoiceBalance),
            ];

            $totalBankInAmount = $banks->sum('in_amount');
            $totalBankOutAmount = $banks->sum('out_amount');
            $totalBankBalance = $banks->sum('balance');

            $drawerCashBalance = $drawerCashInAmount-$drawerCashOutAmount;
            $totalInvoiceDueAmount = $totalInvoiceAmount-$totalInvoicePaidAmount;

            $cashBalance = [
                'cash_at_bank' => money_format($totalBankBalance, 2),
                'draw_cash' => money_format($drawerCashInAmount-$drawerCashOutAmount),
                'supplier_total' => money_format($suppliersTotalBalance),
                'customer_due' => money_format($totalInvoiceAmount-$totalInvoicePaidAmount),
                'total' => money_format($totalBankBalance+$drawerCashBalance+$suppliersTotalBalance+$totalInvoiceDueAmount),
            ];

            $drawerCash = [
                'in_amount' => money_format($drawerCashInAmount),
                'out_amount' => money_format($drawerCashOutAmount),
                'balance' => money_format($drawerCashInAmount-$drawerCashOutAmount),
            ];

            return view('dashboard-print', compact(
                'salesDetails',
                'supplierPaymentDetails',
                'incomeVsExpense',
                'cashBalance',
                'drawerCash',

                'totalInvoiceAmount',
                'totalInvoicePaidAmount',
                'totalInvoiceBalance',
                'totalSupplierCredit',
                'totalSupplierBalance',
                'totalSupplierDepositAmount',
                'totalSupplierExpenseAmount',
                'totalAgentExpenseAmount',
                'totalExpenseAmount',
                'banks',
                'drawerCashInAmount',
                'drawerCashOutAmount',
                'customerAdvanceTypes',
                'suppliersTotalDeposit',
                'suppliersTotalInvoiceTotal',
                'suppliersTotalBalance',
                'suppliersTotalCredit',
            ));
        }

        return view('dashboard');
    }
}
