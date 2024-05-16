<?php

namespace App\Http\Livewire;

use App\Enum\ServiceType;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceCashBalanceComponent extends Component
{
    use WithPagination;

    public $type,
        $q,
        $date,
        $from_date,
        $to_date,
        $customer_id,
        $agent_id,
        $supplier_id,
        $customers,
        $agents,
        $suppliers;

    protected $paginationTheme = 'bootstrap';

    public function mount(
        $type,
        $customers,
        $agents,
        $suppliers
    ): void
    {
        $this->type = $type;
        $this->customers = $customers;
        $this->agents = $agents;
        $this->suppliers = $suppliers;
    }

    public function render()
    {
        $q = $this->q;
        $date = $this->date;
        $fromDate = $this->from_date;
        $toDate = $this->to_date;
        $customer_id = $this->customer_id;
        $agent_id = $this->agent_id;
        $supplier_id = $this->supplier_id;

        $invoicesQuery = Invoice::query()
            ->where('type', $this->type);

        if ($q) {
            $invoicesQuery->where('id', $q)
                ->orWhere('invoice_no', 'LIKE', "%$q%")
                ->orWhere('phone', 'LIKE', "%$q%")
                ->orWhere('name', 'LIKE', "%$q%");
        }

        if ($customer_id) {
            $invoicesQuery->where('customer_id', $customer_id);
        }

        if ($agent_id) {
            $invoicesQuery->where('agent_id', $agent_id);
        }

        if ($supplier_id) {
            $invoicesQuery->where('supplier_id', $supplier_id);
        }

        if ($date) {
            $invoicesQuery->where(function ($query) use ($date) {
                $query->whereDate('issue_date', $date)->orWhereHas('due_payments', function ($query) use ($date) {
                    $query->orWhereDate('date', $date);
                });
            });
        }

        if ($fromDate) {
            $invoicesQuery->where(function ($query) use ($fromDate) {
                $query->whereDate('issue_date', '>=', $fromDate)->orWhereHas('due_payments', function ($query) use ($fromDate) {
                    $query->orWhereDate('date', '>=', $fromDate);
                });
            });
        }

        if ($toDate) {
            $invoicesQuery->where(function ($query) use ($toDate) {
                $query->whereDate('issue_date', '<=', $toDate)->orWhereHas('due_payments', function ($query) use ($toDate) {
                    $query->orWhereDate('date', '<=', $toDate);
                });
            });
        }

        $invoices = $invoicesQuery
            ->latest()
            ->paginate(50);

        $SType = ServiceType::tryFrom($this->type);

        return view('livewire.invoice-cash-balance-component', compact(
            'invoices',
            'SType',
        ));
    }
}
