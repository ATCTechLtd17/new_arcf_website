<?php

namespace App\Http\Livewire;

use App\Models\Investor;
use Livewire\Component;
use Livewire\WithPagination;

class InvestorComponent extends Component
{
    use WithPagination;

    public $investor_id, $name, $phone, $address, $designation;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'designation' => 'nullable|string',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.investor-component', [
            'investors' => Investor::query()
                ->where('type', authUser()->service_type)
                ->paginate(20),
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
        Investor::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'designation' => $this->designation,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investor Added Successfully']);
    }

    public function edit($id): void
    {
        $investor = Investor::find($id);
        if (!blank($investor)) {
            $this->investor_id = $id;
            $this->name = $investor->name;
            $this->phone = $investor->phone;
            $this->designation = $investor->designation;
            $this->address = $investor->address;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Investor::find($this->investor_id)->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'designation' => $this->designation,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investor Update Successfully']);
    }

    public function deleteSupplier($id): void
    {
        $this->investor_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        Investor::find($this->investor_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investor Deleted Successfully']);
    }
}
