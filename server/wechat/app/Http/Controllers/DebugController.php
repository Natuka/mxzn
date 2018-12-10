<?php

namespace App\Http\Controllers;

use App\Events\NotifyEvent;
use App\Models\Engineer;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderId = $request->get('order_id', 0);
        $engineerId = $request->get('engineer_id', 0);

        $order = ServiceOrder::find($orderId);
        $engineer = Engineer::find($engineerId);

        event(new NotifyEvent($order, $engineer));


        return '';
    }
}
