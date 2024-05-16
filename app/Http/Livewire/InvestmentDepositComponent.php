<?php

namespace App\Http\Livewire;

use App\Models\DepositMethod;
use App\Models\DepositSource;
use App\Models\Investment;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\SupplierDeposit;
use Livewire\Component;
use Livewire\WithPagination;

class InvestmentDepositComponent extends Component
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

        return view('livewire.investment-deposit-component', [
            'investments_amount' => Investment::query()
                ->where('type', authUser()->service_type)
                ->sum('amount'),
            'supplier_deposits_amount' => SupplierDeposit::query()
                ->whereIn('supplier_id', $suppliers->pluck('id'))
                ->sum('amount'),
            'supplier_deposits_amount_investment' => SupplierDeposit::query()
                ->whereIn('supplier_id', $suppliers->pluck('id'))
                ->where('source_id', DepositSource::INVESTMENT)
                ->sum('amount'),
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
            'source_id' => DepositSource::BANK_ACCOUNT,
            'created_by_user_id' => authUser()->id,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Deposit Added Successfully']);
    }

    public function edit($id): void
    {
        $supplierDeposit = SupplierDeposit::find($id);
        if (!blank($supplierDeposit)) {
            $this->supplier_deposit_id = $id;
            $this->supplier_id = $supplierDeposit->supplier_id;
            $this->amount = $supplierDeposit->amount;
            $this->service_id = $supplierDeposit->service_id;
            $this->method_id = $supplierDeposit->method_id;
            $this->deposited_by = $supplierDeposit->deposited_by;
            $this->date = $supplierDeposit->date;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        SupplierDeposit::find($this->supplier_deposit_id)->update([
            'supplier_id' => $this->supplier_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'deposited_by' => $this->deposited_by,
            'method_id' => $this->method_id,
            'service_id' => $this->service_id,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Update Successfully']);
    }

    public function delete($id): void
    {
        $this->supplier_deposit_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        SupplierDeposit::find($this->supplier_deposit_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Investment Deleted Successfully']);
    }
}
