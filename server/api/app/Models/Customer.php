<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    //客户编号，系统自动编号：日期年2位月2位日2位+流水码3位
    public static function customerCode($date, $repeat = 4, $format = 'ym')
    {
        $prefix = 'C'.date($format, strtotime($date));
        $last = static::where('number', 'like', $prefix . '%')->orderBy('id', 'desc')->first();

        //第一个
        if (!$last) {
            return $prefix . sprintf('%0' . $repeat . 'd', 1);
        }
        $number = substr($last->number, 5);
        $number = intval($number) +1;
        return $prefix . sprintf('%0' . $repeat . 'd', $number);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
