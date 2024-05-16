<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceDuePayment;
use Illuminate\Http\Request;

class IncomeVsExpenseController extends Controller
{
    public function index(Request $request)
    {
        return view('income-vs-expense');
    }

    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('invoices.print', compact('invoice'));
    }

    public function printReports(Request $request){
        $q = $request->q;
        $date = $request->date;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $type = authUser()->service_type;

        $invoicesQuery = Invoice::query()
            ->where('type', $type);

        $expenses = Expense::query()
            ->where('type', $type);

        if ($q) {
            $invoicesQuery->where('id', $q)
                ->orWhere('invoice_no', 'LIKE', "%$q%")
                ->orWhere('phone', 'LIKE', "%$q%")
                ->orWhere('name', 'LIKE', "%$q%");
        }

        if ($date) {
            $invoicesQuery->whereDate('issue_date', $date);
            $expenses->whereDate('created_at', $date);
        }

        if ($fromDate) {
            $invoicesQuery->whereDate('issue_date', '>=', $fromDate);
            $expenses->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $invoicesQuery->whereDate('issue_date', '<=', $toDate);
            $expenses->whereDate('created_at', '<=', $toDate);
        }

        $invoices = $invoicesQuery
            ->latest()
            ->paginate(50);

        $expenses = $expenses->get();


        $invoicesIds = Invoice::query()
            ->where('type', $type)
            ->pluck('id');

        $payments = InvoiceDuePayment::query()
            ->with(['invoice'])
            ->whereIn('invoice_id', $invoicesIds);

        if ($date) {
            $payments->whereDate('date', $date);
        }

        if ($fromDate) {
            $payments->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $payments->whereDate('date', '<=', $toDate);
        }

        $payments = $payments->latest()->paginate(50);

        return view('income-vs-expense-print', compact('invoices', 'expenses', 'payments', 'date', 'fromDate', 'toDate'));
    }

}
