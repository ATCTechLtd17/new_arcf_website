<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawPurpose extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
