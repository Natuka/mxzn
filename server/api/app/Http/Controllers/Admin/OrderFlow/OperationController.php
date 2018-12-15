<?php
/**
 * Created by PhpStorm.
 * User: natusi
 * Date: 2018-11-03
 * Time: 11:47
 */

namespace App\Http\Controllers\Admin\OrderFlow;


use App\Events\NotifyEvent;
use App\Http\Requests\Admin\ServiceOrder\CancelRequest;
use App\Http\Requests\Admin\ServiceOrder\DispatchRequest;
use App\Http\Requests\Admin\ServiceOrder\SwitchDispatchRequest;
use App\Models\ServiceOrder;
use App\Models\Engineer;
use App\Models\ServiceOrderEngineer;
use App\Models\ServiceOrderRepair;

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
        // 添加工程师
        if (!empty($dispatchEngineer)) {
            $engineer = Engineer::find($dispatchEngineer);
            if ($engineer) {
                $orderEngineer = new ServiceOrderEngineer();
                $new_engineer['service_order_id'] = $order->id;
                $new_engineer['staff_id'] = $engineer->staff_id;
                $new_engineer['staff_name'] = $engineer->staff_name;
                $new_engineer['type'] = 0;
                $new_engineer['is_change'] = 0;
                $orderEngineer->forceFill($new_engineer)->save();

                //产生一笔处理过程
                $orderRepair = new ServiceOrderRepair();
                $new_repair['service_order_id'] = $order->id;
                $new_repair['staff_id'] = $engineer->staff_id;
                $new_repair['staff_name'] = $engineer->staff_name;
                $orderRepair->forceFill($new_repair)->save();

                //送到工单处理
                $order->status = 3;
                $order->save();

                // 微信端通知工程师
                event(new NotifyEvent($order, $engineer));

                return success_json('success');
            }
        }

        return error_json('找不到工程师信息，请检查');

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
     * 工单派工
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
//       \Log::info([
//                'next next' => $dispatchEngineer
//        ]);
       // 添加工程师
        if (!empty($dispatchEngineer)) {
            $engineer = Engineer::find($dispatchEngineer);
            if ($engineer) {
                $orderEngineer = new ServiceOrderEngineer();
                $new_engineer['service_order_id'] = $order->id;
                $new_engineer['staff_id'] = $engineer->staff_id;
                $new_engineer['staff_name'] = $engineer->staff_name;
                $new_engineer['type'] = 0;
                $new_engineer['is_change'] = 0;
                $orderEngineer->forceFill($new_engineer)->save();

                //产生一笔处理过程
                $orderRepair = new ServiceOrderRepair();
                $new_repair['service_order_id'] = $order->id;
                $new_repair['staff_id'] = $engineer->staff_id;
                $new_repair['staff_name'] = $engineer->staff_name;
                $orderRepair->forceFill($new_repair)->save();

                //送到工单处理
                $order->status = 3;
                $order->save();

//               \Log::info([
//                        'orderEngineer789558' => $orderEngineer
//                ]);
                // 微信端通知工程师
                event(new NotifyEvent($order, $engineer));

                return success_json('success');
            }
        }

        return error_json('找不到工程师信息，请检查');
    }
}
