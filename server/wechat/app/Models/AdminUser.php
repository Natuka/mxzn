<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    //

    protected $table = 'users';

    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }
}
