<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investor extends Model
{
    protected $fillable = [
        'type', 'name', 'phone', 'address', 'designation'
    ];

    protected $casts = [
      'type' => ServiceType::class
    ];

    public function investments(): HasMany
    {
        return $this->hasMany(Investment::class);
    }

}
