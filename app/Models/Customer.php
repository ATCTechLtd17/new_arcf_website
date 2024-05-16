<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{

    public $fillable = ['type', 'name', 'phone', 'passport', 'address'];

    protected $casts = [
      'type' => ServiceType::class
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

}
