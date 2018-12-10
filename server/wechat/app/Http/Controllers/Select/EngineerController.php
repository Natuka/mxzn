<?php

namespace App\Http\Controllers\Select;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Engineer;

class EngineerController extends Controller
{
    public function index(Request $request, Engineer $engineer)
    {
        $engineer = $this->search($request, $engineer);

        $list = $this->paginate($engineer);

        return success_json($list);
    }

    public function search(Request $request, Engineer $engineer)
    {
        if ($name = $request->get('name', '')) {
            $engineer = $engineer->where('name', 'like', like($name));
        }

        if ($id = $request->get('id', 0)) {
            $engineer = $engineer->where('id', (int)$id);
        }

//        $engineer->with('code');

        return $engineer;
    }
}
