<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerAdvance extends Model
{
    protected $fillable = [
        'service_type',
        'customer_id',
        'type_id',
        'invoice_id',
        'in_amount',
        'refund_amount',
        'remarks',
        'created_by_user_id',
    ];

    public $casts = [
        'service_type' => ServiceType::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CustomerAdvanceType::class, 'type_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function drawer_cash(): HasOne
    {
        return $this->hasOne(DrawerCash::class);
    }

    public function created_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

}
