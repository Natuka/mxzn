<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{

    public function userable()
    {
        return $this->morphTo();
    }

    /**
     *
     * @param string $openid
     * @return mixed
     */
    public static function findByOpenId($openid = '')
    {
        return static::where('openid', $openid)->first();
    }

    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }
}
