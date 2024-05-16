<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    protected $fillable = [
      'type',
      'name',
      'account_no',
      'address'
    ];

    public $casts = [
        'type' => ServiceType::class,
    ];

    public function cash_at_banks(): HasMany
    {
        return $this->hasMany(CashAtBank::class);
    }

    public function getInAmountAttribute()
    {
      return $this->cash_at_banks->sum('in_amount');
    }

    public function getOutAmountAttribute()
    {
        return $this->cash_at_banks->sum('out_amount');
    }

    public function getBalanceAttribute()
    {
        return $this->in_amount - $this->out_amount;
    }

}
