<?php

namespace App\Http\Controllers\Admin\OrderFlow;

use App\Http\Requests\Admin\OrderFlow\CreateRequest;
use App\Http\Requests\Admin\OrderFlow\UpdateRequest;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstallController extends BaseController
{
    /**
     * 状态，单据状态: 制单中 0, 已受理 1,待派单 2,处理中 3,结算收费 4,已关闭 5,客户回访 6
     * @var integer
     */
    protected $status = 0;

    /**
     * 服务类别: 安装工单 1,保养工单 2,维修工单 3,投诉工单 4,巡检工单 5,移机调试 6，工艺调试 7，试焊申请 8，设备整改 9，培训工单 10
     * $type = 0; 为全部
     * @var integer
     */
    protected $type = 1;

    protected $typeWord = 'I';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order)
    {
        return success_json($this->getList($request, $order));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, ServiceOrder $order)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ServiceOrder $order)
    {
        //
        $data = $request->only([
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
        ]);

        $equipment = $request->get('equipment', []);

        $data['type'] = $this->type;
        $data['number'] = $this->createNumber();

        $data['feedback_at'] = form_date($data['feedback_at'], 'Y-m-d H:i:s');
        $data['receive_at'] = form_date($data['receive_at'], 'Y-m-d H:i:s');
        $data['confirm_at'] = form_date($data['confirm_at'], 'Y-m-d H:i:s');
        $data['plan_out_at'] = form_date($data['plan_out_at'], 'Y-m-d H:i:s');
        $data['plan_finish_at'] = form_date($data['plan_finish_at'], 'Y-m-d H:i:s');

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

            return success_json('创建成功');
        }


        return error_json('创建失败，请检查');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceOrder $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $order)
    {
        //
    }
}
