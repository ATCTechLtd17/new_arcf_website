<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $fillable = ['type', 'name'];

    public const TYPE_TRAVEL_TOURISM = 'TRAVEL_TOURISM';
    public const TYPE_DOCUMENTS_CLEARING = 'DOCUMENTS_CLEARING';

    public function getTypeComputedAttribute(): string
    {
        return $this->type == self::TYPE_TRAVEL_TOURISM ? "Travel and Tourism" : "Documents Clearing";
    }
}
