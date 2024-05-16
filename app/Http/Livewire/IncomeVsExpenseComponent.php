<?php

namespace App\Http\Livewire;

use App\Enum\ServiceType;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\InvoiceDuePayment;
use Livewire\Component;
use Livewire\WithPagination;

class IncomeVsExpenseComponent extends Component
{
    use WithPagination;

    public
        $q,
        $date,
        $from_date,
        $to_date;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $q = $this->q;
        $date = $this->date;
        $fromDate = $this->from_date;
        $toDate = $this->to_date;

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


        return view('livewire.income-vs-expense-component', compact('invoices', 'expenses', 'payments'));
    }
}
