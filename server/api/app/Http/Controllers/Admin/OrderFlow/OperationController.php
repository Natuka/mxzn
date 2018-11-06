<?php
/**
 * Created by PhpStorm.
 * User: natusi
 * Date: 2018-11-03
 * Time: 11:47
 */

namespace App\Http\Controllers\Admin\OrderFlow;


use App\Http\Requests\Admin\ServiceOrder\CancelRequest;
use App\Http\Requests\Admin\ServiceOrder\DispatchRequest;
use App\Http\Requests\Admin\ServiceOrder\SwitchDispatchRequest;
use App\Models\ServiceOrder;

class OperationController extends BaseController
{
    /**
     * 工单转派
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function switchDispatch(ServiceOrder $order, SwitchDispatchRequest $request)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        $dispatchType = $request->get('dispatch_type');
        $dispatchOrgId = $request->get('dispatch_org_id');
        $dispatchEngineer = $request->get('dispatch_engineer');

        // TODO 后续处理

        return success_json('success');
    }

    /**
     * 工单取消
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(ServiceOrder $order, CancelRequest $request)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        // 关闭
        $order->status = 5;
        $order->cancel_status = 1;
        $order->cancel_type = $request->get('cancel_type', 0);
        $order->cancel_cause = e($request->get('cancel_cause', ''));
        $order->save();

        // TODO 之后的其他操作

        return success_json('保存成功');
    }

    /**
     * 工单转派
     * @param ServiceOrder $order
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function orderDispatch(ServiceOrder $order, DispatchRequest $request)
    {
        if (!$order || !$order->id) {
            return error_json('工单不存在');
        }

        $dispatchType = $request->get('dispatch_type');
        $dispatchOrgId = $request->get('dispatch_org_id');
        $dispatchEngineer = $request->get('dispatch_engineer');

        // TODO 后续处理

        return success_json('success');
    }
}
