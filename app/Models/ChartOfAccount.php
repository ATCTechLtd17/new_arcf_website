<?php

namespace App\Models;

use App\Enum\ServiceType;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public $fillable = ['type', 'name'];

    public $casts = [
        'type' => ServiceType::class
    ];

}
