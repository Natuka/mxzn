<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderAttendance extends Model
{
    //
    public static function signed($orderId, $staffId)
    {
        return static::where('service_order_id', $orderId)->where('staff_id', $staffId)
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))
            ->first();
    }
}
