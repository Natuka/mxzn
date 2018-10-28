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

    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }
}
