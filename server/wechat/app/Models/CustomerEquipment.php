<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerEquipment extends Model
{
    /**
     * 查询
     * @param $code
     * @return mixed
     */
    public static function findBy($code)
    {
        return self::where('code_id', $code)->first();
    }

    public function item()
    {
        return $this->hasOne(Machine::class, 'id', 'item_id');
    }

    public static function findByQRCode($qrcodeKey)
    {
        return static::with('item')->where('qrcode_key', $qrcodeKey)->first();
    }
}
