<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    //

    /**
     * 客户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
//        关联查询出部分字段
//        return $this->belongsTo(Customer::class, 'cust_id')->select(['id','name']);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
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
