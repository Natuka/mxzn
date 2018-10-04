<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\TreeTrait;

class Department extends Model
{
    use TreeTrait;

    protected $table = 'base_departments';

    protected static $childrenWithWhere = false;

    protected static $orgId = 0;

    protected static $menu_ids = [];

    protected static $_fields = [
        'id',
        'org_id',
        'parent_id',
        'name',
        'sort_no',
        'number'
    ];

    public function children()
    {
        $children = $this->hasMany(self::class, 'parent_id', 'id');
//            ->orderBy('sort', 'asc');

        if (self::$orgId) {
            $children = $children->where('org_id', self::$orgId);
        }

        if (self::$childrenWithWhere) {
            $children = $children->whereIn('id', self::$menu_ids);
        }

        return $children;
    }

    /**
     * 所属组织
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    /**
     * 所属上级
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        $parent = $this->belongsTo(self::class, 'parent_id');
        if (self::$orgId) {
            $parent = $parent->where('org_id', self::$orgId);
        }

        return $parent;
    }

    /**
     *
     * @param int $parent_id 上级部门
     * @param int $orgId 公司组织
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllByOrganization($parent_id = 0, $orgId = 0)
    {
        self::$orgId = $orgId;

        return static::with(implode('.', array_fill(0, 10, 'children')))
            ->where('parent_id', $parent_id)
            ->where('org_id', $orgId)
//            ->orderBy('sort', 'asc')
            ->get(self::$_fields);
    }

    public static function getFlatByOrganizationId($orgId = 0)
    {
        $ret = [];
        $list = self::getAllByOrganization(0, $orgId);
        return self::__flatByList($list, $ret, self::$_fields);
    }


    /**
     * 获取路径
     * @param int $id
     * @param int $orgId
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getPathById($id = 0, $orgId = 0)
    {
        self::$orgId = $orgId;
        $info = static::with(implode('.', array_fill(0, 10, 'parent')))->find($id);

        $ret = [];

        return self::__getPath($info, $ret, self::$_fields, 'parent');
    }

}
