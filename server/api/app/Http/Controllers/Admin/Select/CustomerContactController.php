<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CustomerContact;
use Illuminate\Http\Request;

class CustomerContactController extends BaseController
{
    //
    public function index(Request $request, CustomerContact $customer)
    {
        $customer = $this->search($request, $customer);

        return $this->paginate($customer);
    }

    public function search(Request $request, CustomerContact $customer)
    {
        if ($name = $request->get('name', '')) {
            $customer = $customer->where('name', 'like', like($name));
        }

        $id = $request->get('customer_id', 0);
        $customer = $customer->where('cust_id', $id);

        return $customer;
    }
}
