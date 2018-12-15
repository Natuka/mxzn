<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    //

    protected $table = 'base_staffs';

    public function user()
    {
        return $this->morphOne(Fan::class, 'userable');
    }

    // 查找员工
    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->where('is_engineer', 1)->first();
    }

    /**
     * 获取粉丝
     * @return mixed
     */
    public function fan()
    {
        return Fan::where('userable_type', 'App\Models\Staff')->where('userable_id', $this->id)->first();
    }
}
