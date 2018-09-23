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
}
