<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceDuePayment extends Model
{
    public $fillable = ['invoice_id', 'amount', 'date', 'remarks', 'issued_by_user_id'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
