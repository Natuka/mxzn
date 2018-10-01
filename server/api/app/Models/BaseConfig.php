<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseConfig extends Model
{
    //

    protected $table = 'base_configs';

    /**
     *
     * @param bool $withChildren
     * @return BaseConfig[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function allTops($withChildren = false)
    {
        if ($withChildren) {
            return static::with('children')->where('parent_id', 0)->get();
        }
        return static::where('parent_id', 0)->get();
    }


    /**
     * 获取所有的子类
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
