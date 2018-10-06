<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;


use App\Models\Order;
use App\Models\ServiceOrderAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order, ServiceOrderAttendance $attendance)
    {
        $attendance = $this->search($request, $order, $attendance);
        return success_json($attendance->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, Order $order, ServiceOrderAttendance $attendance)
    {
        if ($order) {
            $attendance = $attendance->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $attendance_number = $request->get('number', ''); // 客户编号
        $attendance_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $attendance = $attendance->where('industry', (int)$industry);
        }
        if ($type) {
            $attendance = $attendance->where('type', (int)$type);
        }
        if ($level) {
            $attendance = $attendance->where('level', (int)$level);
        }
        if ($source) {
            $attendance = $attendance->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $attendance = $attendance->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($attendance_number) {
            $attendance = $attendance->where('number', 'like', $attendance_number . '%');
        }
        // 客户名称
        if ($attendance_name) {
            $attendance = $attendance->where('name', 'like', '%' . $attendance_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $attendance = $attendance->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $attendance = $attendance->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $attendance;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Order $order, ServiceOrderAttendance $attendance)
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
