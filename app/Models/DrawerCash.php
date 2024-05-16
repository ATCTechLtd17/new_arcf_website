<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrawerCash extends Model
{
    protected $fillable = [
      'type',
      'in_amount',
      'out_amount',
      'deposit_source_id',
      'source_details',
      'invoice_id',
      'supplier_deposit_id',
      'remarks',
      'customer_advance_id',
      'expense_id',
      'bank_id',
      'created_by_user_id',
    ];

    protected $casts = [
        'type' => ServiceType::class,
        'in_amount' => 'float',
        'out_amount' => 'float',
    ];

    public function deposit_source(): BelongsTo
    {
        return $this->belongsTo(DepositSource::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function supplier_deposit(): BelongsTo
    {
        return $this->belongsTo(SupplierDeposit::class);
    }

    public function customer_advance(): BelongsTo
    {
        return $this->belongsTo(CustomerAdvance::class, 'customer_advance_id');
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function getBalanceAttribute()
    {
        return $this->in_amount - $this->out_amount;
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
