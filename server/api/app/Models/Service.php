<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'base_services';

    public static function serviceCode($date, $repeat = 4, $format = 'ym')
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
