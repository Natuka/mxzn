<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderRepair;

class RepairController extends Controller
{
    /**
     * @param CreateRequest $request
     * @param ServiceOrder $order
     * @param ServiceOrderRepair $repair
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
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
        $data['staff_id'] = (int)$data['staff_id'];
        $data['process_id'] = (int)$data['process_id'];
        $data['cause_id'] = (int)$data['cause_id'];
        $data['arrived_at'] = format_date($data['arrived_at']);
        $data['complete_at'] = format_date($data['complete_at']);
        $data['next_step'] = (int)$data['next_step'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

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
                    $save_data['status'] = 4;
                    //$data['progress_time'] = date('Y-m-d H:i:s', time());
                    $order->forceFill($save_data)->save();
                }
            }elseif ($data['next_step'] ==2 || $data['next_step'] ==3) {
//                TODO 通知新的服务工程师处理

            }

            return success_json($repair, '');
        }

        return error_json('新增失败，请检查');

    }

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
