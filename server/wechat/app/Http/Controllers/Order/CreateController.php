<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 工单创建
 * Class CreateController
 * @package App\Http\Controllers\Order
 */
class CreateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ServiceOrder $order)
    {
        //
        $data = $request->only([
            'type',
            'source',
            'customer_id',
            'equipment_id',
            'emergency_degree',
            'level',
            'feedback_at',
            'feedback_staff_id',
            'receive_at',
            'receive_staff_id',
            'confirm_at',
            'confirm_staff_id',
            'is_out',
            'plan_out_at',
            'is_charge',
            'is_quote',
            'plan_finish_at',
            'remark',
            'settle_status',
            'status',
            'attach_ids'    // 附件
        ]);

        $equipment = $request->get('equipment', []);

        //$data['type'] = $this->type;
        $data['number'] = $this->createNumber();

        $data['feedback_at'] = !empty($data['feedback_at']) ? form_date($data['feedback_at'], 'Y-m-d H:i:s') : '';
        $data['receive_at'] = !empty($data['receive_at']) ? form_date($data['receive_at'], 'Y-m-d H:i:s') : '';
        $data['confirm_at'] = !empty($data['confirm_at']) ? form_date($data['confirm_at'], 'Y-m-d H:i:s') : '';
        $data['plan_out_at'] = !empty($data['plan_out_at']) ? form_date($data['plan_out_at'], 'Y-m-d H:i:s') : '';
        $data['plan_finish_at'] = !empty($data['plan_finish_at']) ? form_date($data['plan_finish_at'], 'Y-m-d H:i:s') : '';
        if (empty($data['feedback_at'])) unset($data['feedback_at']);
        if (empty($data['receive_at'])) unset($data['receive_at']);
        if (empty($data['confirm_at'])) unset($data['confirm_at']);
        if (empty($data['plan_out_at'])) unset($data['plan_out_at']);
        if (empty($data['plan_finish_at'])) unset($data['plan_finish_at']);

        if (!empty($equipment)) {
            $data['equipment_id'] = $equipment['id'];
        }

        $order->forceFill($data);

        if ($order->save()) {
            //TODO 执行保存故障信息
            $fault = array_only($request->input('fault', []), [
                'desc',
                'type',
                'sequence',
                'code',
                'is_line_broken',
                'is_part_broken',
            ]);
            $fault['service_order_id'] = $order->id;
            $fault['equipment_id'] = $order->equipment_id;
            //TODO 保存设备文件
            // ....

            $orderFault = new ServiceOrderFault();
            $orderFault->forceFill($fault)->save();

            //TODO 执行保存设备信息


            //TODO 执行保存工程师信息
            $engineers = $request->get('engineers');
            if (!empty($engineers)) {
                foreach ($engineers as $engineer) {
                    $engineer = array_only($engineer, ['staff_id', 'staff_name']);
                    $orderEngineer = new ServiceOrderEngineer();
                    $engineer['service_order_id'] = $order->id;
                    $engineer['type'] = 0;
                    $engineer['is_change'] = 0;
                    $orderEngineer->forceFill($engineer)->save();
                }
            }
            //TODO 执行保存确认工程师信息

            // 创建附件
            $attach_ids = isset($data['attach_ids']) ? explode(',', $data['attach_ids']) : [];
            // 保存附件
            if ($attach_ids) {
                $order->documents()->withTimestamps()->sync($attach_ids);
            }

            return success_json('创建成功');
        }


        return error_json('创建失败，请检查');
    }
}
