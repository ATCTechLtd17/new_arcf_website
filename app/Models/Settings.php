<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    public const ADMIN_LOGIN_URL = 1;

    public const TwoFactorAuthentication = 2;

    public const ADMINER_ID = 3;
}
