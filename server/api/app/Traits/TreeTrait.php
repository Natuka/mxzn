<?php
/**
 * Created by PhpStorm.
 * User: natusi
 * Date: 16/10/8
 * Time: 上午8:58
 */

namespace App\Traits;

trait TreeTrait
{

    public static function __getPath($info, &$ret = [], $fields = [], $parent = 'parent')
    {

        if (!$info) {
            return $ret;
        }

        array_unshift($ret, array_only($info->toArray(), $fields));

        if ($info->$parent) {
            static::__getPath($info->$parent, $ret, $fields, $parent);
        }

        return $ret;
    }

    public static function __flatByList($list, &$ret = [], $fields, $children = 'children')
    {
        if (!count($list)) {
            return $ret;
        }

        foreach ($list as $info) {
            array_push($ret, array_only($info->toArray(), $fields));

            if (count($info->$children)) {
                self::__flatByList($info->$children, $ret, $fields, $children);
            }
        }

        return $ret;
    }
}
