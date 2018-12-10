<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    protected $table = 'base_engineers';
    //
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * 员工
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * 获取粉丝
     * @return mixed
     */
    public function fan()
    {
        return Fan::where('userable_type', 'App\Models\Engineer')->where('userable_id', $this->staff_id)->first();
    }
}
