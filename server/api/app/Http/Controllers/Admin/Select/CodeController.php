<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Code;
use App\Models\Part;
use App\Models\Service;
use Illuminate\Http\Request;

class CodeController extends BaseController
{
    //
    public function index(Request $request, Code $code)
    {
        $code = $this->search($request, $code);

        return $this->paginate($code);
    }

    public function search(Request $request, Code $code)
    {
        if ($name = $request->get('name', '')) {
            $code = $code->where('name', 'like', like($name));
        }

        $itemId = (int)$request->get('item_id');

        $code = $code->where('item_id', $itemId);

        return $code;
    }
}
