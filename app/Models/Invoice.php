<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    public $fillable = [
        'invoice_no',
        'type',
        'name',
        'phone',
        'address',
        'ref_number',
        'issue_date',
        'received_amount',
        'customer_id',
        'agent_id',
        'supplier_id',
        'created_by_user_id',
    ];

    protected $casts = [
      'type' => ServiceType::class,
    ];

    public const TYPE_TRAVEL_TOURISM = 'TRAVEL_TOURISM';
    public const TYPE_DOCUMENTS_CLEARING = 'DOCUMENTS_CLEARING';

    public function getTypeComputedAttribute(): string
    {
        return $this->type == self::TYPE_TRAVEL_TOURISM ? "Travel and Tourism" : "Documents Clearing";
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(InvoiceService::class);
    }

    public function due_payments(): HasMany
    {
        return $this->hasMany(InvoiceDuePayment::class);
    }

    public function getDuePaidAmountAttribute()
    {
        $this->load('due_payments');

        return $this->due_payments->sum('amount');
    }

    public function getTotalBalanceAttribute()
    {
        $this->load('services');

        return $this->services->sum('balance');
    }

    public function getTotalAmountAttribute()
    {
        $this->load('services');

        return $this->services->sum('total_amount');
    }

    public function getTotalTaxAmountAttribute()
    {
        $this->load('services');

        return $this->services->sum('tax_amount');
    }

    public function getDueBalanceAttribute()
    {
        return $this->total_balance - $this->received_amount;
    }

    public function getDueAmountAttribute()
    {
        return $this->total_amount - $this->received_amount;
    }

    public function getTotalPaidAmountAttribute()
    {
        return $this->due_paid_amount + $this->received_amount;
    }

    public function getPaymentStatusAttribute(): string
    {
        return $this->due_amount != 0 ? "Due" : "Paid";
    }

    public function getTotalSupplierRateAttribute()
    {
        $this->load('services');

        return $this->services->sum('total_supplier_rate');
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public static function getInvoiceNo($type)
    {
        return Invoice::query()
                ->where('type', $type)
                ->latest()
                ->first()?->invoice_no + 1;
    }

}
