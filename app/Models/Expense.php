<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    public $fillable = [
        'type',
        'chart_of_account_id',
        'agent_id',
        'supplier_id',
        'transaction_date',
        'created_by_user_id',
    ];

    protected $casts = [
      'type' => ServiceType::class
    ];

    public function chart_of_account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ExpenseDetail::class);
    }

    public function getTotalRateAttribute()
    {
        $this->load('details');

        return $this->details->sum('rate');
    }

    public function getTotalAmountAttribute()
    {
        $this->load('details');

        return $this->details->sum('amount')+$this->total_tax_amount;
    }

    public function getTotalQuantityAttribute()
    {
        $this->load('details');

        return $this->details->sum('quantity');
    }

    public function getTotalTaxAmountAttribute()
    {
        $this->load('details');

        return $this->details->sum('total_tax_amount');
    }

    public function getTotalTaxPercentageAttribute()
    {
        $this->load('details');

        return $this->details->sum('tax_percentage');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

}
