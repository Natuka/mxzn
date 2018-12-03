<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //
    protected $table = 'base_staffs';

    //员工编号，系统自动编号：日期年2位月2位日2位+流水码3位
    public static function staffCode($date, $repeat = 4, $format = 'ym')
    {
        $prefix = date($format, strtotime($date));
        $last = static::where('number', 'like', $prefix . '%')->orderBy('id', 'desc')->first();

        //第一个
        if (!$last) {
            return $prefix . sprintf('%0' . $repeat . 'd', 1);
        }
        return $last->number + 1;
    }


    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * 部门
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dept()
    {
        return $this->belongsTo(Department::class, 'dep_id');
//        关联查询出部分字段
//        return $this->belongsTo(Customer::class, 'cust_id')->select(['id','name']);
    }


    /**
     * 组织/公司
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
//        关联查询出部分字段
//        return $this->belongsTo(Customer::class, 'cust_id')->select(['id','name']);
    }
}
