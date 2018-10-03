<?php

namespace App\Http\Controllers\Admin\OrderFlow;

use App\Http\Requests\Admin\OrderFlow\CreateRequest;
use App\Http\Requests\Admin\OrderFlow\UpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RepairController extends BaseController
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
    protected $type = 3;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order)
    {
        return success_json($this->getList($request, $order));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Order $order)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
