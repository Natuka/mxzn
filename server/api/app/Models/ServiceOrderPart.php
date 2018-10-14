<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderPart extends Model
{
    //
    public function part()
    {
        return $this->hasOne(Part::class, 'id', 'base_part_id');
    }
    //
    public function code()
    {
        return $this->hasOne(Code::class, 'id', 'base_code_id');
    }
}
