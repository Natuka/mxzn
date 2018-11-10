<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'fans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
//        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function findByMobile($mobile)
    {
        return static::where('mobile', $mobile)->first();
    }

    public static function findByOpenid($openid)
    {
        return static::where('openid', $openid)->first();
    }

    /**
     * 关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function userable()
    {
        return $this->morphTo();
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'userable_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'userable_id', 'id');
    }
}
