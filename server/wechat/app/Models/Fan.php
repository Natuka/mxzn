<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
    //

    public function userable()
    {
        return $this->morphTo();
    }

    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }
}
