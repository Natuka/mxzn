<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{

    protected $appends = ['customer'];

    //
    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }

    public function getCustomerAttribute()
    {
        return $this->customer()->first();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    /**
     * 用户信息
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(Fan::class, 'userable');
    }

    /**
     * 用户信息
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function fan()
    {
        return $this->morphOne(Fan::class, 'userable');
    }

}
