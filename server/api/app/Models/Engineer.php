<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engineer extends Model
{
    //
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
