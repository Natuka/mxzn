<?php

namespace App\Http\Controllers\Order;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderConfirm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluateController extends Controller
{
    //
    public function store(ServiceOrder $order, Request $request)
    {
        $user = $this->user();
        $customer = $this->customer();
        $confirm = new ServiceOrderConfirm();

        $data = $request->only([
            'is_solve',
            'overall_satisfaction',
            'timeliness',
            'service_staff_atisfaction',
            'cost_performance',
            'confirm_user_id',
            'confirm_user_name',
            'opinions_suggestions',

        ]);

        $data['confirm_user_id'] = $user->userable_id;
        $data['confirm_user_name'] = $user->info->name;
        $data['service_order_id'] = $order->id;

        $confirm = $confirm->forceFill($data);

        $confirm->save();

        return success_json('感谢您的评价');
    }
}
