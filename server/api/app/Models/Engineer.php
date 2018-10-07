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
}
