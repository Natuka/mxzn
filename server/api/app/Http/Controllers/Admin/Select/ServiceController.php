<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    //
    public function index(Request $request, Service $service)
    {
        $service = $this->search($request, $service);

        return $this->paginate($service);
    }

    public function search(Request $request, Service $service)
    {
        if ($name = $request->get('name', '')) {
            $service = $service->where('name', 'like', like($name));
        }

        return $service;
    }
}
