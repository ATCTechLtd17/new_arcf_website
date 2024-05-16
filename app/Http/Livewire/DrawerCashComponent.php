<?php

namespace App\Http\Livewire;

use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class DrawerCashComponent extends Component
{
    use WithPagination;

    public $drawer_cash_id, $in_amount, $out_amount, $deposit_source_id, $source_details, $invoice_id, $remarks;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'in_amount' => 'nullable',
        'out_amount' => 'nullable',
        'deposit_source_id' => 'nullable',
        'source_details' => 'nullable',
        'remarks' => 'nullable',
    ];

    public function render()
    {
        $depositSources = DepositSource::all();
        $invoices = Invoice::where('type', authUser()->service_type)->get();
        return view('livewire.drawer-cash-component', [
            'deposit_sources' => $depositSources,
            'invoices' => $invoices,
            'drawer_cashes' => DrawerCash::query()
                ->where('type', authUser()->service_type)
                ->latest()
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
        DrawerCash::create([
            'type' => authUserServiceType(),
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'deposit_source_id' => $this->deposit_source_id,
            'source_details' => $this->source_details,
            'remarks' => $this->remarks,
            'created_by_user_id' => authUser()->id,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Drawer Cash Added Successfully']);
    }

    public function edit($id): void
    {
        $drawerCash = DrawerCash::find($id);
        if (!blank($drawerCash)) {
            $this->drawer_cash_id = $id;
            $this->in_amount = $drawerCash->in_amount;
            $this->out_amount = $drawerCash->out_amount;
            $this->deposit_source_id = $drawerCash->deposit_source_id;
            $this->source_details = $drawerCash->source_details;
            $this->invoice_id = $drawerCash->invoice_id;
            $this->remarks = $drawerCash->remarks;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        DrawerCash::find($this->drawer_cash_id)->update([
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'deposit_source_id' => $this->deposit_source_id,
            'source_details' => $this->source_details,
            'invoice_id' => $this->invoice_id,
            'remarks' => $this->remarks,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Drawer Cash Update Successfully']);
    }

    public function delete($id): void
    {
        $this->drawer_cash_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        DrawerCash::find($this->drawer_cash_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Drawer Cash Deleted Successfully']);
    }
}
