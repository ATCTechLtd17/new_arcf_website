<?php

namespace App\Http\Livewire;

use App\Models\Bank;
use App\Models\CashAtBank;
use App\Models\DepositMethod;
use App\Models\WithdrawPurpose;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class CashAtBankComponent extends Component
{
    use WithPagination;

    public
        $cash_at_bank_id,
        $bank_id,
        $in_amount,
        $out_amount,
        $deposit_method_id,
        $withdraw_purpose_id,
        $withdraw_purpose_id_query,
        $date,
        $voucher_no,
        $transaction_done_by,
        $remarks,
        $from_date,
        $to_date;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'bank_id' => 'required',
        'in_amount' => 'nullable',
        'out_amount' => 'nullable',
        'date' => 'required',
        'transaction_done_by' => 'required',
    ];

    public function render()
    {
        $fromDate = $this->from_date;
        $toDate = $this->to_date;
        $withdraw_purpose_id = $this->withdraw_purpose_id_query;

        $cashAtBanksQuery = CashAtBank::query()
            ->with(['bank', 'deposit_method', 'created_by_user'])
            ->where('type', authUser()->service_type);

        if ($withdraw_purpose_id) {
            $cashAtBanksQuery->where('withdraw_purpose_id', $withdraw_purpose_id);
        }

        if ($fromDate) {
            $cashAtBanksQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $cashAtBanksQuery->whereDate('created_at', '<=', $toDate);
        }

        return view('livewire.cash-at-bank-component', [
            'cash_at_banks' => $cashAtBanksQuery->latest()->paginate(20),
            'banks' => Bank::where('type', authUser()->service_type)->get(),
            'deposit_methods' => DepositMethod::all(),
            'withdraw_purposes' => WithdrawPurpose::all(),
        ]);
    }

    public function add(): void
    {
        $this->reset();
        $this->date = Carbon::now()->toDateString();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-modal']);
    }

    public function addCashOut(): void
    {
        $this->reset();
        $this->date = Carbon::now()->toDateString();
        $this->dispatchBrowserEvent('show-modal', ['id' => 'add-cash-out-modal']);
    }

    public function submit(): void
    {
        $this->validate();

        if ($this->out_amount) {
            $bank = Bank::findOrFail($this->bank_id);
            if ($bank->balance < $this->out_amount) {
                $this->dispatchBrowserEvent('error', ['msg' => 'Bank account balance is low!']);
                return;
            }
        }

        CashAtBank::create([
            'type' => authUser()->service_type,
            'bank_id' => $this->bank_id,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'deposit_method_id' => $this->deposit_method_id,
            'withdraw_purpose_id' => $this->withdraw_purpose_id,
            'date' => $this->date,
            'voucher_no' => $this->voucher_no,
            'transaction_done_by' => $this->transaction_done_by,
            'remarks' => $this->remarks,
            'created_by_user_id' => authUser()->id
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'add-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Cash at Bank Added Successfully']);
    }

    public function edit($id): void
    {
        $cashAtBank = CashAtBank::find($id);
        if (!blank($cashAtBank)) {
            $this->cash_at_bank_id = $id;
            $this->bank_id = $cashAtBank->bank_id;
            $this->in_amount = $cashAtBank->in_amount;
            $this->out_amount = $cashAtBank->out_amount;
            $this->deposit_method_id = $cashAtBank->deposit_method_id;
            $this->withdraw_purpose_id = $cashAtBank->withdraw_purpose_id;
            $this->date = $cashAtBank->date;
            $this->voucher_no = $cashAtBank->voucher_no;
            $this->transaction_done_by = $cashAtBank->transaction_done_by;
            $this->remarks = $cashAtBank->remarks;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'update-modal']);
        }
    }

    public function update(): void
    {
        $this->validate();
        CashAtBank::find($this->cash_at_bank_id)->update([
            'bank_id' => $this->bank_id,
            'in_amount' => $this->in_amount,
            'out_amount' => $this->out_amount,
            'deposit_method_id' => $this->deposit_method_id,
            'withdraw_purpose_id' => $this->withdraw_purpose_id,
            'date' => $this->date,
            'voucher_no' => $this->voucher_no,
            'transaction_done_by' => $this->transaction_done_by,
            'remarks' => $this->remarks,
        ]);
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'update-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Cash at Bank Update Successfully']);
    }

    public function delete($id): void
    {
        $this->cash_at_bank_id = $id;
        $this->dispatchBrowserEvent('show-modal', ['id' => 'delete-modal']);
    }

    public function deleteConfirm(): void
    {
        CashAtBank::find($this->cash_at_bank_id)->delete();
        $this->dispatchBrowserEvent('hide-modal', ['id' => 'delete-modal']);
        $this->dispatchBrowserEvent('success', ['msg' => 'Cash at Bank Deleted Successfully']);
    }
}
