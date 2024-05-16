<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceService extends Model
{
    public $fillable = [
        'invoice_id',
        'service_id',
        'quantity',
        'sales_rate',
        'supplier_rate',
        'agent_commission',
        'tax_percentage',
        'remarks',
    ];

    protected $appends = ['balance'];

    public function getTotalSalesRateAttribute(): float|int
    {
        return $this->sales_rate*$this->quantity;
    }

    public function getTotalSupplierRateAttribute(): float|int
    {
        return $this->supplier_rate*$this->quantity;
    }

    public function getTotalAgentCommissionAttribute(): float|int
    {
        return $this->agent_commission*$this->quantity;
    }

    public function getBalanceAttribute()
    {
        return $this->total_sales_rate - $this->total_supplier_rate - $this->total_agent_commission - $this->tax_amount;
    }

    public function getTaxAmountAttribute(): float|int
    {
        return $this->total_sales_rate/100*$this->tax_percentage;
    }

    public function getTotalAmountAttribute(): float|int
    {
        return $this->total_sales_rate+$this->tax_amount;
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

}
