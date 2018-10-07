<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    //
    public function index(Request $request, Customer $customer)
    {
        $customer = $this->search($request, $customer);

        return $this->paginate($customer);
    }

    public function search(Request $request, Customer $customer)
    {
        if ($name = $request->get('name', '')) {
            $customer = $customer->where('name', 'like', like($name));
        }

        if ($id = $request->get('id', 0)) {
            $customer = $customer->where('id', $id);
        }

        return $customer;
    }
}
