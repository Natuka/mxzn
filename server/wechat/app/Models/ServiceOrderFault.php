<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderFault extends Model
{
    //
    public function equipment()
    {
        return $this->belongsTo(CustomerEquipment::class, 'equipment_id');
    }
}
