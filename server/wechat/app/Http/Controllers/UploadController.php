<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function post(Request $request)
    {
        $file = $request->file('file');

        return $file;
    }
}
