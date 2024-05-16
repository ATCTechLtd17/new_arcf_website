<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\CashAtBank;
use App\Models\DepositMethod;
use App\Models\DrawerCash;
use App\Models\Investment;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class DrawerCashToCashAtBankComponent extends Component
{
    use WithPagination;

    public $supplier_deposit_id, $supplier_id, $amount, $date, $deposited_by, $method_id, $service_id, $bank_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'supplier_id' => 'required',
        'bank_id' => 'required',
        'amount' => 'required',
        'service_id' => 'required',
        'method_id' => 'required',
    ];

    public function render()
    {
        $depositMethods = DepositMethod::all();
        $services = Service::where('type', authUser()->service_type)->get();
        $drawerCashBalance = DrawerCash::where('type', authUser()->service_type)->get()->sum('balance');

        return view('livewire.drawer-cash-to-cash-at-bank-component', [
            'investments_amount' => Investment::query()
                ->where('type', authUser()->service_type)
                ->sum('amount'),
            'depositMethods' => $depositMethods,
            'services' => $services,
            'drawerCashBalance' => $drawerCashBalance,
            'banks' => Bank::where('type', authUser()->service_type)->get(),
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

        if ($this->amount) {
            $drawerCashBalance = DrawerCash::where('type', authUser()->service_type)->get()->sum('balance');
            if ($drawerCashBalance < $this->amount) {
                $this->dispatchBrowserEvent('error', ['msg' => 'Drawer cash balance is low!']);
                return;
            }
        }

        $drawerCash = DrawerCash::create([
            'type' => authUserServiceType(),
            'out_amount' => $this->amount,
            'remarks' => "Drawer Cash to Bank",
            'created_by_user_id' => authUser()->id,
        ]);

        CashAtBank::create([
            'type' => authUser()->service_type,
            'bank_id' => $this->bank_id,
            'in_amount' => $this->amount,
            'date' => $this->date,
            'transaction_done_by' => $this->deposited_by,
            'remarks' => "Drawer Cash to Bank",
            'drawer_cash_id' => $drawerCash->id,
            'created_by_user_id' => authUser()->id
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Added Successfully']);
    }
}
