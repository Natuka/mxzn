<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Http\Request;

class PartController extends BaseController
{
    //
    public function index(Request $request, Part $part)
    {
        $part = $this->search($request, $part);
        $part = $part->selectRaw("*,CONCAT(number,',',name,',',model) AS show_name");
        return $this->paginate($part);
    }

    public function search(Request $request, Part $part)
    {
        $name = $request->get('name', '');
        if (empty($name)) {
            $name = $request->get('show_name', '');
        }
        if (!empty($name)) {
//            $part = $part->where('name', 'like', like($name));
            $part = $part->where(function($query) use($name)
            {
                $query->where('name', 'like', like($name))
                    ->orWhere('number', 'like', like($name))
                    ->orWhere('model', 'like', like($name));
            });
        }

        if ($id = $request->get('id', 0)) {
            $part = $part->where('id', (int)$id);
        }

        $part->with('code');

        return $part;
    }
}
