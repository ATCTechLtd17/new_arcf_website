<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailRecipient extends Model
{
    protected $fillable = [
        'name',
        'email',
        'is_active',
    ];
}
