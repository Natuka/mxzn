<?php

namespace App\Http\Controllers\Order;

use App\Events\NotifyEvaluateEvent;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderConfirm;
use App\Models\ServiceOrderRepair;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluateController extends Controller
{
    //
    public function store(ServiceOrder $order, Request $request)
    {
        $user = $this->user();
        $customer = $this->customer();
//        需求改变，直接写在处理过程，BYERIC
//        $confirm = new ServiceOrderConfirm();
        //ServiceOrderRepair

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
//        $data['service_order_id'] = $order->id;

//        $confirm = $confirm->forceFill($data);
//        $confirm->save();

        return success_json('感谢您的评价');
    }

    /**
     * 评价列表
     * @param Request $request
     */
    public function index(Request $request)
    {

        $user = $this->user();
        if (!$user) {
            return error_json('没有权限', 403);
        }

        $customer = $this->customer();

        if (!$customer) {
            return error_json('没有权限', 403);
        }

        $builder = ServiceOrder::with([
            'fault',
        ])
            ->where('customer_id', $customer->cust_id)
            ->where('status', 5)
            ->orderBy('id', 'desc')
            ->first();

        return success_json($builder);
    }

    /**
     * 最近一笔待评价工单
     * @param Request $request
     */
    public function last(Request $request)
    {
        $user = $this->user();
        if (!$user) {
            return error_json('没有权限', 403);
        }

        $customer = $this->customer();

        if (!$customer) {
            return error_json('没有权限', 403);
        }

        $builder = ServiceOrder::with([
            'fault',
            'repairs',
        ])
            ->where('customer_id', $customer->cust_id)
            ->where('status', 5)
            ->orderBy('id', 'desc')
            ->first();

        if (!$builder) {
            return error_json('工单不存在或未完工', 404);
        }

        return success_json($builder);

    }
}
