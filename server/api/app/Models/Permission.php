<?php

namespace App\Models;

use App\Traits\TreeTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $perPage = 30;

    use TreeTrait;

    protected $primaryKey = 'id';

    protected $table = 'permissions';

    protected static $childrenWithWhere = false;

    protected static $menu_ids = [];

    protected $fillable = [
        'name',
        'display_name',
        'parent_id',
        'controller',
        'route',
        'icon',
        'remark',
        'visible',
    ];

    public function children()
    {
        $children = $this->hasMany(self::class, 'parent_id', 'id')->orderBy('sort', 'asc');

        if (!config('menu.show', true)) {
            $children->where('show', 1);
        }

        if (self::$childrenWithWhere) {
            $children->whereIn('id', self::$menu_ids);
        }

        return $children;
    }

    public function childrenShow()
    {
        $children = $this->hasMany(self::class, 'parent_id', 'id', 'parent');

//        $children->where('show', 1);

        return $children;
    }

    public function parent()
    {
        $parent = $this->belongsTo(self::class, 'parent_id');

        if (!config('menu.show', true)) {
            $parent->where('show', 0);
        }

        return $parent;
    }

    /**
     * 获取显示列表
     * @param int $parent_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getShowMenus($parent_id = 0)
    {
        // children.children.children.children.children.children
        return static::with(implode('.', array_fill(0, 10, 'children')))->where('parent_id', $parent_id)->get();
    }

    /**
     *
     * @param int $parent_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getMenus($parent_id = 0)
    {
        return static::with(implode('.', array_fill(0, 10, 'children')))
            ->where('parent_id', $parent_id)
            ->orderBy('sort', 'asc')
            ->get();
    }

    /**
     * 获取父级
     * @param $alias
     * @return Model|null|static
     */
    public static function getPathsByAlias($alias)
    {
        $info = static::with(implode('.', array_fill(0, 10, 'parent')))->where('alias', $alias)->first();
        $ret = [];
        return self::__getPath($info, $ret, ['name', 'route', 'display_name'], 'parent');
    }

    /**
     * 获取路径
     * @param int $menu_id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getPathById($menu_id = 0)
    {
        $info = static::with(implode('.', array_fill(0, 10, 'parent')))->find($menu_id);

        $ret = [];

        return self::__getPath($info, $ret, ['name', 'route', 'display_name'], 'parent');
    }

    public static function getWithRole($parent_id = 0)
    {
        return static::childrenRole($parent_id);
    }

    /**
     * 子节点
     * @param  integer $parent_id [description]
     * @return [type]             [description]
     */
    public static function childrenRole($parent_id = 0)
    {
        $user = admin_user();

        // 超级管理员不在查询
        if ($user->is_super) {
            self::$childrenWithWhere = false;
            $ret = static::with(implode('.', array_fill(0, 10, 'children')))
                ->where('parent_id', $parent_id)
                ->orderBy('sort', 'asc')
                ->get();
            return $ret; 
        }

        $roles = $user->roles()->get(['id']);

        $menu_ids = [];

        foreach ($roles as $role) {
            $menu_ids += $role->menus()->pluck('id')->toArray();
        }

        $menu_ids = array_unique($menu_ids);

        self::$childrenWithWhere = true;

        self::$menu_ids = $menu_ids;

        $ret = static::with(implode('.', array_fill(0, 10, 'children')))
            ->whereIn('id', $menu_ids)
            ->where('parent_id', $parent_id)
            ->orderBy('sort', 'asc')
            ->get();
        self::$childrenWithWhere = false;

        return $ret;
    }
}
