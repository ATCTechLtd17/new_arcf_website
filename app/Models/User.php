<?php

namespace App\Models;

use App\Enum\ServiceType;
use App\Traits\PasswordResetTrait;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int id
 * @property string name
 * @property string type
 * @property string service_type
 * @property string phone
 * @property string|null photo_uri
 * @property string|null verify_code
 * @property string|null phone_verified_at
 * @property string|null email
 * @property string|null email_verified_at
 * @property string password
 * @property bool is_active
 * @property bool is_two_factor_auth
 * @property string|null last_active_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, PasswordResetTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'service_type',
        'phone',
        'email',
        'phone_verified_at',
        'password',
        'verify_code',
        'photo_uri',
        'is_active',
        'last_active_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_type' => ServiceType::class,
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|numeric',
        'email' => 'string|email|max:255',
        'password' => 'required|string|min:6|confirmed',
    ];

    public const TYPE_ACCOUNTANT = 'ACCOUNTANT';
    public const TYPE_ADMIN = 'ADMIN';

    /**
     * @return HasOne
     */
    public function password_reset(): HasOne
    {
        return $this->hasOne(PasswordReset::class);
    }

    /**
     * @return User|null
     */
    public static function current(): ?User
    {
        return request()->user();
    }

}
