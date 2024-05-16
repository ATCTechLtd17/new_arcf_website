<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseDetail extends Model
{
    public $fillable = ['expense_id', 'rate', 'quantity', 'tax_percentage','description', 'remarks'];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function getTotalAmountAttribute(): float|int
    {
        return $this->amount+$this->tax_amount;
    }

    public function getAmountAttribute(): float|int
    {
        return $this->rate * $this->quantity;
    }

    public function getTaxAmountAttribute(): float|int
    {
        return $this->rate/100*$this->tax_percentage;
    }

    public function getTotalTaxAmountAttribute(): float|int
    {
        return $this->amount/100*$this->tax_percentage;
    }
}
