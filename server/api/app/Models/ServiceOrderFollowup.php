<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderFollowup extends Model
{

    public function followup_staff()
    {
        return $this->hasOne(Staff::class, 'id', 'followup_staff_id');
    }

    public function handle_staff()
    {
        return $this->hasOne(Staff::class, 'id', 'handle_staff_id');
    }
}
