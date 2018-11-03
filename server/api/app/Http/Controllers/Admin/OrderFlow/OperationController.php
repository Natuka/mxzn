<?php
/**
 * Created by PhpStorm.
 * User: natusi
 * Date: 2018-11-03
 * Time: 11:47
 */

namespace App\Http\Controllers\Admin\OrderFlow;


use App\Models\ServiceOrder;

class OperationController extends BaseController
{
    /**
     * 工单转派
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchDispatch(ServiceOrder $order)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        return success_json('success');
    }

    /**
     * 工单取消
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(ServiceOrder $order)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        return success_json('success');
    }

    /**
     * 工单取消
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function orderDispatch(ServiceOrder $order)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        return success_json('success');
    }
}
