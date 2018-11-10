<?php

namespace App\Http\Controllers\Admin\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;

class DocController extends Controller
{
    use UploadTrait;


    public function store(Request $request)
    {
        return $this->uploadFile($request);
    }

    public function get(Request $request)
    {
        return $this->getFile($request);
    }
}
