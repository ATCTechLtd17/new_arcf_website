<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierDeposit extends Model
{
    protected $fillable = [
        'supplier_id',
        'bank_id',
        'amount',
        'date',
        'deposited_by',
        'method_id',
        'service_id',
        'source_id',
        'remarks',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(DepositMethod::class, 'method_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(DepositSource::class, 'source_id');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function updated_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }

}
