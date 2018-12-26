<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends BaseController
{
    //
    public function index(Request $request, Staff $staff)
    {
        $staff = $this->search($request, $staff);

        return $this->paginate($staff);
    }

    public function search(Request $request, Staff $staff)
    {
        $staff = $staff->where('status', 1);
        if ($name = $request->get('name', '')) {
            $staff = $staff->where('name', 'like', like($name));
        }

        return $staff;
    }
}
