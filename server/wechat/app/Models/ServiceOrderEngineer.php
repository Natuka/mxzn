<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderEngineer extends Model
{
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
}
