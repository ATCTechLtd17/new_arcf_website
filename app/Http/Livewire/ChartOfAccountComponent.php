<?php

namespace App\Http\Livewire;

use App\Models\ChartOfAccount;
use Livewire\Component;
use Livewire\WithPagination;

class ChartOfAccountComponent extends Component
{
    use WithPagination;

    public $chart_of_account_id, $name;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string'
    ];

    public function render()
    {
        return view('livewire.chart-of-account-component', [
            'chartOfAccounts' => ChartOfAccount::where('type', authUserServiceType())->paginate(20),
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
        ChartOfAccount::create([
            'type' => authUser()->service_type,
            'name' => $this->name,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Chart of Account Added Successfully']);
    }

    public function edit($id): void
    {
        $chartOfAccount = ChartOfAccount::find($id);
        if (!blank($chartOfAccount)) {
            $this->chart_of_account_id = $id;
            $this->name = $chartOfAccount->name;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        ChartOfAccount::find($this->chart_of_account_id)->update([
            'name' => $this->name,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Chart of Account Update Successfully']);
    }

    public function delete($id): void
    {
        $this->chart_of_account_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        ChartOfAccount::find($this->chart_of_account_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Chart Of Account Deleted Successfully']);
    }
}
