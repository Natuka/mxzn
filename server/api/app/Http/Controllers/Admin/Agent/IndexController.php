<?php

namespace App\Http\Controllers\Admin\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //

    public function index()
    {
        return response()->json([
            'code' => 0,
            'message' => 'Ok',
            'data' => []
        ]);

        return response()->json([
            'code' => 1,
            'message' => 'Ok',
            'data' => []
        ]);
    }
}
