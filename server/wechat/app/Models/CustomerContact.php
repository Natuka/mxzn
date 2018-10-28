<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    //
    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }
}
