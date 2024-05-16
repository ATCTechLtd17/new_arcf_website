<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerAdvanceType extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function advances(): HasMany
    {
        return $this->hasMany(CustomerAdvance::class, 'type_id');
    }

    public function getInAmountAttribute()
    {
        return $this->advances()->sum('in_amount');
    }

    public function getRefundAmountAttribute()
    {
        return $this->advances()->sum('refund_amount');
    }

    public function getBalanceAttribute()
    {
        return $this->in_amount-$this->refund_amount;
    }

}
