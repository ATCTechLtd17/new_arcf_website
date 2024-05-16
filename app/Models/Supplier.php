<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    public $fillable = ['type', 'name', 'phone', 'company_name', 'address', 'service_id'];

    public $casts = [
        'type' => ServiceType::class,
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getTotalInvoiceAmountAttribute()
    {
        return $this->invoices->sum('total_amount');
    }

    public function getTotalInvoiceRateAmountAttribute()
    {
        return $this->invoices->sum('total_supplier_rate');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(SupplierDeposit::class);
    }

    public function getTotalDepositAmountAttribute()
    {
        return $this->deposits->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return $this->total_deposit_amount - $this->total_invoice_rate_amount;
    }

    public function getCreditAttribute()
    {
        if($this->total_deposit_amount < $this->total_invoice_amount){
            return $this->balance;
        }

        return null;
    }
}
