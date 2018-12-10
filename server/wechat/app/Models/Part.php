<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    //
    protected $table = 'base_items';

    public function code()
    {
        return $this->hasOne(Code::class, 'item_id', 'id');
    }
}
