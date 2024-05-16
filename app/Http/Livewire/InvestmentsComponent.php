<?php

namespace App\Http\Livewire;

use App\Models\Investment;
use App\Models\Investor;
use Livewire\Component;
use Livewire\WithPagination;

class InvestmentsComponent extends Component
{
    use WithPagination;

    public $investment_id, $amount, $datetime, $investor_id, $remarks;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'investor_id' => 'required',
        'amount' => 'required',
        'datetime' => 'required',
        'remarks' => 'nullable',
    ];

    public function render()
    {
        return view('livewire.investments-component', [
            'investments' => Investment::query()
                ->where('type', authUser()->service_type)
                ->paginate(20),
            'investors' => Investor::query()
                ->where('type', authUser()->service_type)
                ->get(),
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
        Investment::create([
            'type' => authUser()->service_type,
            'investor_id' => $this->investor_id,
            'amount' => $this->amount,
            'datetime' => $this->datetime,
            'remarks' => $this->remarks,
            'created_by_user_id' => authUser()->id
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Added Successfully']);
    }

    public function edit($id): void
    {
        $investment = Investment::find($id);
        if (!blank($investment)) {
            $this->investment_id = $id;
            $this->investor_id = $investment->investor_id;
            $this->amount = $investment->amount;
            $this->datetime = $investment->datetime;
            $this->remarks = $investment->remarks;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        Investment::find($this->investment_id)->update([
            'investor_id' => $this->investor_id,
            'amount' => $this->amount,
            'datetime' => $this->datetime,
            'remarks' => $this->remarks,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Update Successfully']);
    }

    public function delete($id): void
    {
        $this->investment_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        Investment::find($this->investment_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Deleted Successfully']);
    }
}
