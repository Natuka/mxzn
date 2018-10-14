<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderRepair extends Model
{
    //
    protected $appends = ['progress_use_time'];


    public function getProgressUseTimeAttribute()
    {
        $complete_at = $this->attributes['complete_at'];
        $arrived_at = $this->attributes['arrived_at'];
    }

}
