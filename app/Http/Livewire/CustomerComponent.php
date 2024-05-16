<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerComponent extends Component
{
    use WithPagination;

    public $customer_id, $name, $phone, $passport, $address;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'passport' => 'nullable|string',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.customer-component', [
            'customers' => Customer::where('type', authUserServiceType())->paginate(20),
        ]);
    }

    public function add(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-modal']);
    }

    public function submit(): void
    {
        $this->validate();
        Customer::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'passport' => $this->passport,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Added Successfully']);
    }

    public function edit($id): void
    {
        $customer = Customer::find($id);
        if (!blank($customer)) {
            $this->customer_id = $id;
            $this->name = $customer->name;
            $this->phone = $customer->phone;
            $this->passport = $customer->passport;
            $this->address = $customer->address;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Customer::find($this->customer_id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'passport' => $this->passport,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Update Successfully']);
    }

    public function deleteSupplier($id): void
    {
        $this->customer_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        Customer::find($this->customer_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Customer Deleted Successfully']);
    }
}
