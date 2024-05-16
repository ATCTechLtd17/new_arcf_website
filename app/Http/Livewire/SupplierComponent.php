<?php

namespace App\Http\Livewire;

use App\Models\Service;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierComponent extends Component
{
    use WithPagination;

    public $supplier_id, $name, $phone, $company_name, $address, $service_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'company_name' => 'nullable|string',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.supplier-component', [
            'suppliers' => Supplier::where('type', authUserServiceType())->paginate(20),
            'services' => Service::where('type', authUser()->service_type)->get(),
        ]);
    }

    public function addSupplier(): void
    {
        $this->reset();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-supplier-modal']);
    }

    public function submit(): void
    {
        $this->validate();
        Supplier::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'service_id' => $this->service_id,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-supplier-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Supplier Added Successfully']);
    }

    public function editSupplier($id): void
    {
        $supplier = Supplier::find($id);
        if (!blank($supplier)) {
            $this->supplier_id = $id;
            $this->name = $supplier->name;
            $this->phone = $supplier->phone;
            $this->company_name = $supplier->company_name;
            $this->address = $supplier->address;
            $this->service_id = $supplier->service_id;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-supplier-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Supplier::find($this->supplier_id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'service_id' => $this->service_id,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-supplier-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Supplier Update Successfully']);
    }

    public function deleteSupplier($id): void
    {
        $this->supplier_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-supplier-modal']);
    }

    public function deleteConfirm(): void
    {
        Supplier::find($this->supplier_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-supplier-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Supplier Deleted Successfully']);
    }
}
