<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutStaff extends Model
{
    //

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
