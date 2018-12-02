<?php

namespace App\Http\Controllers\Equipment;

use App\Models\CustomerEquipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //

    public function index()
    {
        $user = $this->user();

        if (!$user->isCustomer) {
            return success_json([]);
        }

        if (!$user->info || !$user->info->customer) {
            return success_json([]);
        }

        $customer = $user->info->customer;

        $list = CustomerEquipment::where('cust_id', $customer->id)->limit(30)->get();

        return success_json($list);
    }
}
