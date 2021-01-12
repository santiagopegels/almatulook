<?php

namespace App;

use App\Models\Admin\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Overwrite the password with the encrypted value
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email' => 'required|email|unique:users,email',
        'password'  => 'required|confirmed'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules_update = [
        'email' => 'required|email|unique:users,email',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules_password = [
        'password'  => 'required|confirmed'
    ];
}
