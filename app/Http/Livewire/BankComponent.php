<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use Livewire\Component;
use Livewire\WithPagination;

class BankComponent extends Component
{
    use WithPagination;

    public $bank_id, $name, $account_no, $address;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string',
        'account_no' => 'required|string',
        'address' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.bank-component', [
            'banks' => Bank::where('type', authUserServiceType())->paginate(20),
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
        Bank::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
            'account_no' => $this->account_no,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Bank Added Successfully']);
    }

    public function edit($id): void
    {
        $bank = Bank::find($id);
        if (!blank($bank)) {
            $this->bank_id = $id;
            $this->name = $bank->name;
            $this->account_no = $bank->account_no;
            $this->address = $bank->address;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Bank::find($this->bank_id)->update([
            'name' => $this->name,
            'account_no' => $this->account_no,
            'address' => $this->address
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Bank Update Successfully']);
    }

    public function delete($id): void
    {
        $this->bank_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        Bank::find($this->bank_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Bank Deleted Successfully']);
    }
}
