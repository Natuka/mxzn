<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CustomerContact;
use App\Models\Engineer;
use Illuminate\Http\Request;

class EngineerController extends BaseController
{
    //
    public function index(Request $request, Engineer $engineer)
    {
        $engineer = $this->search($request, $engineer);

        return $this->paginate($engineer);
    }

    public function search(Request $request, Engineer $engineer)
    {
        if ($name = $request->get('name', '')) {
            $engineer = $engineer->where('staff_name', 'like', like($name));
        }

        if ($org_id =$request->get('org_id', 0)) {
            $engineer = $engineer->where('org_id', $org_id);
        }

//        $id = $request->get('customer_id', 0);
//        $engineer = $engineer->where('cust_id', $id);

        return $engineer;
    }
}
