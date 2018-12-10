<?php

namespace App\Http\Controllers\Select;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;

class ProjectController extends Controller
{

    /** 获取列表
     * @param Request $request
     * @param Service $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, Service $service)
    {
        $service = $this->search($request, $service);

        $list = $this->paginate($service);

        return success_json($list);
    }

    public function search(Request $request, Service $service)
    {
        if ($name = $request->get('name', '')) {
            $service = $service->where('name', 'like', like($name));
        }

        return $service;
    }
}
