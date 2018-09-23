<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function findBy($input, $field = 'email')
    {
        return self::where($field, $input)->first();
    }

    public static function findByEmailMobileName($input)
    {
        return self::where('email', $input)
        ->orWhere('name', $input)
        ->orWhere('mobile', $input)
        ->first();
    }
}
