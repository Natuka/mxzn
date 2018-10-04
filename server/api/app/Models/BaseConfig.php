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

    /**
     * 获取子项列表
     * @param string $name
     * @param array $fields
     * @return \Illuminate\Support\Collection
     */
    public static function childrenByName($name = '', $fields = ['*']) {
        if (empty($name)) {
            return collect([]);
        }

        $parentId = config('base_config.' . $name, '');

        if (!$parentId) {
            return collect([]);
        }

        return static::where('parent_id', $parentId)->get($fields);
    }


    /**
     * 获取子项列表
     * @param string $name
     * @param array $fields
     * @return \Illuminate\Support\Collection
     */
    public static function childrenByNameWithPage($name = '', $fields = ['*'], $perPage = 10, $page = 1) {
        if (empty($name)) {
            return collect([]);
        }

        $parentId = config('base_config.' . $name, '');

        if (!$parentId) {
            return collect([]);
        }

        return static::where('parent_id', $parentId)->paginate($perPage, $fields);
    }
}
