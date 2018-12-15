<?php

namespace App\Http\Controllers\Order;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 签到
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ServiceOrder $order, ServiceOrderAttendance $attendance)
    {
        if (!$order->id) {
            return error_json('工单不存在', 400);
        }
        // TODO 判断是否是此用户

        $user = $this->user();
        $staff = $user->staff();

        if (ServiceOrderAttendance::signed($order->id, $staff->id)) {
            return error_json('已签到过', 400);
        }

        $attendance->forceFill([
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'service_order_id' => $order->id,
            'signin_time' => date('Y-m-d H:i:s'),
            'location' => '',
            'coordinate' => '',
        ])->save();

        return error_json('签到成功', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
