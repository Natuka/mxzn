<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerEquipment extends Model
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


}
