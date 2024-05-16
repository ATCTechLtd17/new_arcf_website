<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepositSource extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public const CASH_IN_HAND = 1;
    public const INVESTMENT = 2;
    public const BANK_ACCOUNT = 3;

    public const DUE_COLLECTION = 6;
    public const ADVANCE_COLLECTION = 7;

    public function supplier_deposits(): HasMany
    {
        return $this->hasMany(SupplierDeposit::class, 'source_id');
    }
}
