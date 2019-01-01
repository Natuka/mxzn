<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\CustomerEquipment;
use Illuminate\Http\Request;

class CustomerEquipmentController extends BaseController
{
    //
    public function index(Request $request, CustomerEquipment $customer)
    {
        $customer = $this->search($request, $customer);
        $customer = $customer->selectRaw("*,CONCAT(number,',',name,',',IF(sets IS NULL, '', sets)) AS show_name");
        return $this->paginate($customer);
    }

    public function search(Request $request, CustomerEquipment $customer)
    {
        $name = $request->get('name', '');
        if (empty($name)) {
            $name = $request->get('show_name', '');
        }
        if (!empty($name)) {
            $customer = $customer->where(function($query) use($name)
            {
                $query->where('name', 'like', like($name))
                    ->orWhere('number', 'like', like($name))
                    ->orWhere('model', 'like', like($name))
                    ->orWhere('sets', 'like', like($name))
                    ->orWhere('main_no', 'like', like($name))
                    ->orWhere('main_model', 'like', like($name))
                    ->orWhere('control_box_no', 'like', like($name))
                    ->orWhere('control_box_model', 'like', like($name))
                    ->orWhere('welding_machine_no', 'like', like($name))
                    ->orWhere('welding_machine_model', 'like', like($name));
            });
        }
        if ($name = $request->get('show_name', '')) {
            $customer = $customer->where('name', 'like', like($name));
        }

        $id = $request->get('id', 0);
        if ((int)$id > 0) {
            $customer = $customer->where('id', (int)$id);
        }
        $cust_id = $request->get('customer_id', 0);
        $customer = $customer->where('cust_id', $cust_id);

        return $customer;
    }
}
