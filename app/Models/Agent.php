<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agent extends Model
{
    public $fillable = ['type', 'name', 'phone', 'company_name', 'address'];

    public $casts = [
      'type' => ServiceType::class,
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

}
