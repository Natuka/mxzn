<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Machine;
use Illuminate\Http\Request;

class MaterielController extends BaseController
{
    //
    public function index(Request $request, Machine $machine)
    {
        $machine = $this->search($request, $machine);

        return $this->paginate($machine);
    }

    public function search(Request $request, Machine $machine)
    {
        if ($name = $request->get('name', '')) {
            $machine = $machine->where('name', 'like', like($name));
        }

        $itemId = (int)$request->get('item_id');
        if ($itemId > 0) {
            $machine = $machine->where('id', $itemId);
        }

        return $machine;
    }
}
