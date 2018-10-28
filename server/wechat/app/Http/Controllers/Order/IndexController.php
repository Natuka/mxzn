<?php

namespace App\Http\Controllers\Order;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = ServiceOrder::with([
            'fault',
            'documents',
            'customer',
            'engineers',
            'feedbackStaff',
            'receiveStaff',
            'confirmStaff',
        ])->paginate();

        return success_json($data);
    }

    public function get()
    {
//        return view('order.repair-info');
    }
}
