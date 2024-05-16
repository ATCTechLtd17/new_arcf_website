<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\CustomerAdvance;
use App\Models\CustomerAdvanceType;
use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAdvanceComponent extends Component
{
    use WithPagination;

    public $advance_id, $type_id, $invoice_id, $customer_id, $in_amount, $refund_amount, $remarks;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'type_id' => 'required',
        'invoice_id' => 'nullable',
        'in_amount' => 'nullable',
        'refund_amount' => 'nullable',
        'remarks' => 'nullable',
    ];

    public function render()
    {
        $types = CustomerAdvanceType::all();
        $customers = Customer::where('type', authUser()->service_type)->get();
        $invoices = Invoice::where('type', authUser()->service_type)->get();
        return view('livewire.customer-advance-component', [
            'types' => $types,
            'invoices' => $invoices,
            'customers' => $customers,
            'advances' => CustomerAdvance::query()
                ->where('service_type', authUserServiceType())
                ->latest()
                ->get(),
        ]);
    }

    public function add(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-modal']);
    }

    public function addCustomer(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-customer-modal']);
    }

    public function submit(): void
    {
        $this->validate();
        $invoice = Invoice::find($this->invoice_id);
        $customerAdvance = CustomerAdvance::create([
            'service_type' => authUserServiceType(),
            'customer_id' => $invoice->customer_id,
            'type_id' => $this->type_id,
            'invoice_id' => $this->invoice_id,
            'in_amount' => $this->in_amount,
            'refund_amount' => $this->refund_amount,
            'remarks' => $this->remarks,
            'created_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'customer_advance_id' => $customerAdvance->id,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->refund_amount,
            'deposit_source_id' => DepositSource::ADVANCE_COLLECTION,
            'remarks' => "Customer Advance payment",
            'created_by_user_id' => authUser()->id,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Advance Added Successfully']);
    }

    public function edit($id): void
    {
        $advance = CustomerAdvance::find($id);
        $invoice = Invoice::find($advance->invoice_id);
        if (!blank($advance)) {
            $this->advance_id = $id;
            $this->type_id = $advance->type_id;
            $invoice->customer_id = $advance->customer_id;
            $this->invoice_id = $advance->invoice_id;
            $this->in_amount = $advance->in_amount;
            $this->refund_amount = $advance->refund_amount;
            $this->remarks = $advance->remarks;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        $invoice = Invoice::find($this->invoice_id);
        $customerAdvance = CustomerAdvance::find($this->advance_id);
        $customerAdvance->update([
            'customer_id' => $invoice->customer_id,
            'type_id' => $this->type_id,
            'invoice_id' => $this->invoice_id,
            'in_amount' => $this->in_amount,
            'refund_amount' => $this->refund_amount,
            'remarks' => $this->remarks,
        ]);

        $customerAdvance->drawer_cash?->update([
            'in_amount' => $this->in_amount,
            'out_amount' => $this->refund_amount,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Advance Update Successfully']);
    }

    public function submitCustomer(): void
    {
        $this->validate();
        $customerAdvance = CustomerAdvance::create([
            'service_type' => authUserServiceType(),
            'customer_id' => $this->customer_id,
            'type_id' => $this->type_id,
            'in_amount' => $this->in_amount,
            'refund_amount' => $this->refund_amount,
            'remarks' => $this->remarks,
            'created_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'customer_advance_id' => $customerAdvance->id,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->refund_amount,
            'deposit_source_id' => DepositSource::ADVANCE_COLLECTION,
            'remarks' => "Customer Advance payment",
            'created_by_user_id' => authUser()->id,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-customer-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Advance Added Successfully']);
    }

    public function editCustomer($id): void
    {
        $advance = CustomerAdvance::find($id);
        if (!blank($advance)) {
            $this->advance_id = $id;
            $this->type_id = $advance->type_id;
            $this->customer_id = $advance->customer_id;
            $this->in_amount = $advance->in_amount;
            $this->refund_amount = $advance->refund_amount;
            $this->remarks = $advance->remarks;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-customer-modal']);
        }
    }

    public function updateCustomer(): void
    {
        $this->validate();
        $customerAdvance = CustomerAdvance::find($this->advance_id);
        $customerAdvance->update([
            'customer_id' => $this->customer_id,
            'type_id' => $this->type_id,
            'in_amount' => $this->in_amount,
            'refund_amount' => $this->refund_amount,
            'remarks' => $this->remarks,
        ]);

        $customerAdvance->drawer_cash?->update([
            'in_amount' => $this->in_amount,
            'out_amount' => $this->refund_amount,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-customer-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Advance Update Successfully']);
    }

}
