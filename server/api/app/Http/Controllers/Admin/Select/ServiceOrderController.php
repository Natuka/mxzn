<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends BaseController
{
    //
    public function index(Request $request, ServiceOrder $serviceorder)
    {
        $serviceorder = $this->search($request, $serviceorder);

        return $this->paginate($serviceorder);
    }

    public function search(Request $request, ServiceOrder $serviceorder)
    {
        $serviceorder = $serviceorder->where('status', '<', 4);
        if ($name = $request->get('number', '')) {
            $serviceorder = $serviceorder->where('number', 'like', like($name));
        }

        if ($id = $request->get('id', 0)) {
            $serviceorder = $serviceorder->where('id', $id);
        }

        //排序
        $serviceorder = $serviceorder->orderBy('id', 'desc');

        return $serviceorder;
    }
}
