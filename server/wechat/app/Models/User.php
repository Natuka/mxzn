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
        'password', 'remember_token', 'userable_type', 'userable_id'
    ];

    protected $appends = ['is_customer', 'is_engineer', 'is_admin', 'info'];


    public function getIsCustomerAttribute()
    {
        return $this->isCustomer();
    }

    public function getIsEngineerAttribute()
    {
        return $this->isEngineer();
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function getInfoAttribute()
    {
        return $this->userable;
    }


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
        return $this->belongsTo(CustomerContact::class, 'userable_id', 'id');
    }


    public function isCustomer()
    {
        return $this->attributes['userable_type'] === 'App\Models\CustomerContact';
    }

    public function isEngineer()
    {
        return $this->attributes['userable_type'] === 'App\Models\Staff';
    }

    public function isAdmin()
    {
        return $this->attributes['userable_type'] === 'App\Models\AdminUser';
    }
}
