<?php

namespace App\Http\Livewire;

use App\Enum\ServiceType;
use App\Models\Invoice;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class InvoicesComponent extends Component
{
    use WithPagination;

    public $type, $name,
        $isCustomer,
        $isAgent,
        $isSupplier,
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
        $name,
        $isCustomer,
        $isAgent,
        $isSupplier,
        $customers,
        $agents,
        $suppliers
    ): void
    {
        $this->type = $type;
        $this->name = $name;
        $this->isCustomer = $isCustomer;
        $this->isAgent = $isAgent;
        $this->isSupplier = $isSupplier;
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
            $invoicesQuery->whereDate('issue_date', $date);
        }

        if ($fromDate) {
            $invoicesQuery->whereDate('issue_date', '>=', $fromDate);
        }

        if ($toDate) {
            $invoicesQuery->whereDate('issue_date', '<=', $toDate);
        }

        $invoices = $invoicesQuery
            ->latest()
            ->paginate(50);

        $SType = ServiceType::tryFrom($this->type);

        $supplierBalance = 0;
        $supplierDeposit = 0;
        if($supplier_id){
            $supplier = Supplier::find($supplier_id);
            $supplierBalance = $supplier?->balance;
            $supplierDeposit = $supplier?->total_deposit_amount;
        }

        return view('livewire.invoices-component', compact(
            'invoices',
            'SType',
            'supplierBalance',
            'supplierDeposit',
        ));
    }
}
