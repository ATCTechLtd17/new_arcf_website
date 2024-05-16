<?php

namespace App\Http\Livewire;

use App\Models\DepositMethod;
use App\Models\DepositSource;
use App\Models\DrawerCash;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierDeposit;
use Livewire\Component;
use Livewire\WithPagination;

class DrawerCashToSupplierDepositComponent extends Component
{
    use WithPagination;

    public $supplier_deposit_id, $supplier_id, $amount, $date, $deposited_by, $method_id, $service_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'supplier_id' => 'required',
        'amount' => 'required',
        'service_id' => 'required',
        'method_id' => 'required',
    ];

    public function render()
    {
        $suppliers = Supplier::query()
            ->where('type', authUser()->service_type)
            ->get();

        $depositMethods = DepositMethod::all();
        $services = Service::where('type', authUser()->service_type)->get();

        return view('livewire.drawer-cash-to-supplier-deposit-component', [
            'in_amount' => DrawerCash::query()
                ->where('type', authUser()->service_type)
                ->sum('in_amount'),
            'out_amount' => DrawerCash::query()
                ->where('type', authUser()->service_type)
                ->sum('out_amount'),
            'depositMethods' => $depositMethods,
            'services' => $services,
            'suppliers' => $suppliers,
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
        SupplierDeposit::create([
            'supplier_id' => $this->supplier_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'deposited_by' => $this->deposited_by,
            'method_id' => $this->method_id,
            'service_id' => $this->service_id,
            'source_id' => DepositSource::CASH_IN_HAND,
            'created_by_user_id' => authUser()->id,
        ]);

        DrawerCash::create([
            'type' => authUserServiceType(),
            'out_amount' => $this->amount,
            'remarks' => "Drawer to Supplier Transfer",
            'created_by_user_id' => authUser()->id,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Supplier Deposit Added Successfully']);
    }

    public function edit($id): void
    {

    }

    public function update(): void
    {

    }

    public function delete($id): void
    {

    }

    public function deleteConfirm(): void
    {

    }
}
