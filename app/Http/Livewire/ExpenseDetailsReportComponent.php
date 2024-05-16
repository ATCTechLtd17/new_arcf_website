<?php

namespace App\Http\Livewire;

use App\Models\ChartOfAccount;
use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;

class ExpenseDetailsReportComponent extends Component
{
    use WithPagination;

    public $q,
        $date,
        $from_date,
        $to_date,
        $chart_of_account_id,
        $agent_id,
        $supplier_id,
        $customers;

    protected $paginationTheme = 'bootstrap';

    public function mount(): void
    {

    }

    public function render()
    {
        $q = $this->q;
        $date = $this->date;
        $fromDate = $this->from_date;
        $toDate = $this->to_date;
        $agent_id = $this->agent_id;
        $supplier_id = $this->supplier_id;
        $chartOfAccountId = $this->chart_of_account_id;

        $type = authUser()->service_type->value;

        $expenses = Expense::query()
            ->where('type', $type);

        if ($q) {
//            $expenses->where('id', $q)
//                ->orWhere('invoice_no', 'LIKE', "%$q%")
//                ->orWhere('phone', 'LIKE', "%$q%")
//                ->orWhere('name', 'LIKE', "%$q%");
        }

        if ($chartOfAccountId) {
            $expenses->where('chart_of_account_id', $chartOfAccountId);
        }

        if ($agent_id) {
            $expenses->where('agent_id', $agent_id);
        }

        if ($supplier_id) {
            $expenses->where('supplier_id', $supplier_id);
        }

        if ($date) {
            $expenses->whereDate('created_at', $date);
        }

        if ($fromDate) {
            $expenses->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $expenses->whereDate('created_at', '<=', $toDate);
        }

        $chartOfAccounts = ChartOfAccount::query()
            ->where('type', $type)
            ->get();

        $expenses = $expenses
            ->latest()
            ->paginate(50);

        return view('livewire.expense-details-report-component', compact(
            'expenses',
            'chartOfAccounts'
        ));
    }
}
