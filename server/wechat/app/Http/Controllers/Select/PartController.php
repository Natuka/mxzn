<?php

namespace App\Http\Controllers\Select;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Part;

class PartController extends Controller
{
    public function index(Request $request, Part $part)
    {
        $part = $this->search($request, $part);

        $list = $this->paginate($part);

        return success_json($list);
    }

    public function search(Request $request, Part $part)
    {
        if ($name = $request->get('name', '')) {
            $part = $part->where('name', 'like', like($name));
        }

        if ($id = $request->get('id', 0)) {
            $part = $part->where('id', (int)$id);
        }

        $part->with('code');

        return $part;
    }
}
