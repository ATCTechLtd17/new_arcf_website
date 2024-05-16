<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\ChartOfAccount;
use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Expense;
use App\Models\ExpenseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $type = authUser()->service_type->value;

        $chartOfAccounts = ChartOfAccount::query()
            ->where('type', $type)
            ->get();
        $agents = Agent::query()
            ->where('type', $type)
            ->get();
        $suppliers = Supplier::query()
            ->where('type', $type)
            ->get();

        $expenses = Expense::query()
            ->where('type', $type)
            ->latest()
            ->simplePaginate(20);

        $editId = $request->get('editId');
        $viewId = $request->get('viewId');
        $expenseEdit = Expense::query()
            ->where('type', $type)
            ->find($editId);
        $expenseView = Expense::query()
            ->where('type', $type)
            ->find($viewId);

        return view('expense.index', compact(
                'chartOfAccounts',
                'agents',
                'suppliers',
                'expenses',
                'expenseEdit',
                'expenseView',
            )
        );
    }

    public function detailsReport(Request $request)
    {
        return view('expense.reports.details');
    }

    public function print($id)
    {
        $type = authUser()->service_type->value;

        $expense = Expense::query()
            ->where('type', $type)
            ->findOrFail($id);

        return view('expense.print', compact('expense'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chart_of_account_id' => 'required',
        ]);

        $type = authUser()->service_type->value;

        $expense = Expense::create([
            'type' => $type,
            'chart_of_account_id' => $request->get('chart_of_account_id'),
            'agent_id' => $request->get('agent_id'),
            'supplier_id' => $request->get('supplier_id'),
            'transaction_date' => $request->get('transaction_date'),
            'created_by_user_id' => authUser()->id,
        ]);

        $descriptions = $request->get('descriptions');
        $rates = $request->get('rates');
        $quantities = $request->get('quantities');
        $taxes = $request->get('taxes');
        $remarks = $request->get('remarks');

        foreach ($descriptions as $key => $description) {
            if ($description != null && @$rates[$key] != null && @$quantities[$key] != null) {
                ExpenseDetail::create([
                    'expense_id' => $expense->id,
                    'rate' => @$rates[$key],
                    'quantity' => @$quantities[$key],
                    'tax_percentage' => @$taxes[$key],
                    'description' => $description,
                    'remarks' => $remarks[$key],
                ]);
            }
        }

        DrawerCash::create([
            'type' => authUserServiceType(),
            'out_amount' => $expense->total_amount,
            'remarks' => $expense->chart_of_account->name,
            'expense_id' => $expense->id,
            'created_by_user_id' => authUser()->id,
        ]);

        return back()->with('success', 'Expense Created');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chart_of_account_id' => 'required',
        ]);

        $expense = Expense::findOrFail($id);

        $expense->update([
            'chart_of_account_id' => $request->get('chart_of_account_id'),
            'agent_id' => $request->get('agent_id'),
            'supplier_id' => $request->get('supplier_id'),
            'transaction_date' => $request->get('transaction_date'),
        ]);

        $descriptions = $request->get('descriptions');
        $rates = $request->get('rates');
        $quantities = $request->get('quantities');
        $taxes = $request->get('taxes');
        $remarks = $request->get('remarks');

        $expense->details()->delete();

        foreach ($descriptions as $key => $description) {
            if ($description != null && @$rates[$key] != null && @$quantities[$key] != null) {
                ExpenseDetail::create([
                    'expense_id' => $expense->id,
                    'rate' => @$rates[$key],
                    'quantity' => @$quantities[$key],
                    'tax_percentage' => @$taxes[$key],
                    'description' => $description,
                    'remarks' => $remarks[$key],
                ]);
            }
        }

        return back()->with('success', 'Expense Updated');
    }

}
