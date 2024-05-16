<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashAtBank extends Model
{
    protected $fillable = [
        'type',
        'bank_id',
        'in_amount',
        'out_amount',
        'deposit_method_id',
        'withdraw_purpose_id',
        'date',
        'voucher_no',
        'transaction_done_by',
        'remarks',
        'drawer_cash_id',
        'invoice_due_payment_id',
        'created_by_user_id',
    ];

    protected $casts = [
        'type' => ServiceType::class,
        'in_amount' => 'float',
        'out_amount' => 'float',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    public function deposit_method(): BelongsTo
    {
        return $this->belongsTo(DepositMethod::class);
    }

    public function withdraw_purpose(): BelongsTo
    {
        return $this->belongsTo(WithdrawPurpose::class);
    }

    public function drawer_cash(): BelongsTo
    {
        return $this->belongsTo(DrawerCash::class, 'drawer_cash_id');
    }

    public function invoice_due_payment(): BelongsTo
    {
        return $this->belongsTo(InvoiceDuePayment::class, 'invoice_due_payment_id');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function getBalanceAttribute()
    {
        return $this->in_amount - $this->out_amount;
    }
}
