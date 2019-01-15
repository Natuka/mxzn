<?php

namespace App\Http\Controllers\Order;

use App\Events\NotifyEvaluateEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderRepair;

class RepairController extends Controller
{
    public function index(Request $request, $order, ServiceOrderRepair $repair)
    {
//        $user = $this->user();
//        $staff = $this->staff();
//        if (!$staff) {
//            return success_json([]);
//        }

        $list = $repair->where('service_order_id', $order)->orderBy('id', 'desc')->get();
//        $list = $repair->where('staff_id', $staff->id)->where('service_order_id', $order)->get();
        return success_json($list);
    }

    /**
     * @param CreateRequest $request
     * @param ServiceOrder $order
     * @param ServiceOrderRepair $repair
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
        $user = $this->user();

        if (!$user) {
            return error_json('请先登录');
        }

        $staff = $user->staff;

        if (!$staff) {
            return error_json('没有权限', 403);
        }

        $data = $request->only([
            'staff_id',
            'staff_name',
            'process_id',
            'process',
            'step_result',
            'step_doc_ids',
            'arrived_at',
            'complete_at',
            'cause_id',
            'cause',
            'cause_doc_ids',
            'next_step',
        ]);
        if ($staff) {
            $data['staff_id'] = $staff->id;
            $data['staff_name'] = $staff->name;
            $created_by = $updated_by = $staff->name;
        }else{
            $data['staff_id'] = 0;
            $data['staff_name'] = '';
            $created_by = $updated_by = '新增';
        }

        $data['process_id'] = (int)$data['process_id'];
        $data['cause_id'] = (int)$data['cause_id'];
        $data['arrived_at'] = format_date($data['arrived_at'], 'Y-m-d H:i:s');
        $data['complete_at'] = format_date($data['complete_at'], 'Y-m-d H:i:s');
        $data['next_step'] = (int)$data['next_step'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = $created_by;
        $data['updated_by'] = $updated_by;

        $ret = $repair->forceFill($data)->save();

        if ($ret) {
            $this->saveDocWithType($order, 1, $repair->step_doc_ids);
            $this->saveDocWithType($order, 2, $repair->cause_doc_ids);

            /*          下步处理，选择完工关闭，工单状态修改为：待结算
            下步处理，选择暂不关闭，工单状态不变：处理中
            下步处理，选择内部派工，工单状态不变：处理中，通知新的服务工程师处理
            下步处理，选择派给网点，工单状态不变：处理中，通知新的服务工程师处理*/
            if ($data['next_step'] ==1) {
//                下步处理，选择完工关闭，工单状态修改为：待结算
                if ($order) {
                    //$this->assignToContact($info['id'], $user->id);
                    $save_data['status'] = 5;
                    //$data['progress_time'] = date('Y-m-d H:i:s', time());
                    $order->forceFill($save_data)->save();
                    // 通知给客户进行评价
                    event(new NotifyEvaluateEvent($order));
                }
            }else {
//                TODO 通知新的服务工程师处理 if ($data['next_step'] ==2 || $data['next_step'] ==3)
                if ($order) {
                    // 通知给客户进行评价
                    event(new NotifyEvaluateEvent($order));
                }
            }

            return success_json($repair, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * 保存类型
     * @param ServiceOrder $order
     * @param int $type
     * @param string $ids
     */
    public function saveDocWithType(ServiceOrder $order, $type = 1, $ids = '')
    {
        if (!$ids) {
            $ids = [];
        } else {
            $ids = explode(',', $ids);
        }

        $ret = [];
        foreach ($ids as $id) {
            $ret[$id] = [
                'type' => $type,
            ];
        }

        $order->documents($type)->withTimestamps()->sync($ret);
    }

    public function info(Request $request)
    {
        return redirect('/?#' . $request->getRequestUri());
    }
}
