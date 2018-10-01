<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends BaseController
{
    /**
     * 获取基础资料
     * @param Request $request
     * @param Department $department
     * @return mixed
     */
    public function index(Request $request, Department $department)
    {
        $department = $this->search($request, $department);

        return $this->paginate($department);
    }

    public function search(Request $request, Department $department)
    {
        if ($name = $request->get('name', '')) {
            $department = $department->where('name', like($name));
        }

        return $department;
    }
}
