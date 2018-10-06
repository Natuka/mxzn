<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CustomerContact;
use App\Models\CustomerEquipment;
use Illuminate\Http\Request;

class CustomerEquipmentController extends BaseController
{
    //
    public function index(Request $request, CustomerEquipment $customer)
    {
        $customer = $this->search($request, $customer);

        return $this->paginate($customer);
    }

    public function search(Request $request, CustomerEquipment $customer)
    {
        if ($name = $request->get('name', '')) {
            $customer = $customer->where('name', 'like', like($name));
        }

        $id = $request->get('customer_id', 0);
        $customer = $customer->where('cust_id', $id);

        return $customer;
    }
}
