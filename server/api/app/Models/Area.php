<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $perPage = 30;
    public $timestamps = false;

    protected static $cacheTime = 7 * 24 * 60 * 30 * 10000;

    protected static $_fields = ['id', 'areaname', 'parent_id', 'shortname', 'areacode', 'zipcode', 'pinyin', 'lng', 'lat', 'level', 'position', 'sort', 'first', 'is_hot'];

    /**
     * 获取省份
     * @return [type] [description]
     */
    public static function provinces()
    {
        return static::areas();
    }

    /**
     * 获取所有的城市
     * @return [type] [description]
     */
    public static function allCities()
    {
        // 7 * 24 * 60 * 30 * 10000
        return Cache::remember('all_cities_1', static::$cacheTime, function () {
            return static::select(self::$_fields)->where('level', 2)->get();
        });
    }

    /**
     * 获取所有的城市
     * @return [type] [description]
     */
    public static function allWithCoutries()
    {
        return Cache::remember('all_with_countries_1', static::$cacheTime, function () {
            return static::select(self::$_fields)->where('level', '<', 4)->get();
        });
    }

    /**
     * 省市
     * @param  integer $provinceId [description]
     * @return [type]              [description]
     */
    public static function cities($provinceId = 0)
    {
        return static::areas('cities_', $provinceId, 2);
    }

    /**
     * 县市区
     * @param  integer $cities [description]
     * @return [type]          [description]
     */
    public static function countries($cities = 0)
    {
        return static::areas('countries_', $cities, 3);
    }

    /**
     * 街道
     * @param  integer $countries [description]
     * @return [type]             [description]
     */
    public static function streets($countries = 0)
    {
        return static::areas('streets_', $countries, 4);
    }

    /**
     * 获取地区列表
     * @param  string $prefix [description]
     * @param  [type]  $parentId [description]
     * @param  integer $level [description]
     * @return [type]            [description]
     */
    public static function areas($prefix = 'provinces_', $parentId, $level = 1)
    {
        return Cache::remember($prefix . $parentId, static::$cacheTime, function () use ($parentId, $level) {
            return static::select(self::$_fields)->where('level', $level)->where('parent_id', $parentId)->get();
        });
    }
}
