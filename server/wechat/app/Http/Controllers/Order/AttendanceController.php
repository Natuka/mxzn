<?php

namespace App\Http\Controllers\Order;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderAttendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ServiceOrder $order, ServiceOrderAttendance $attendance)
    {
        if (!$order->id) {
            return error_json('工单不存在', 400);
        }
        // TODO 判断是否是此用户

        $user = $this->user();

        if (!$user->isEngineer()) {
            return error_json('没有权限');
        }

        $staff = $user->staff;

        if (!$staff) {
            return error_json('没有权限');
        }

//        if (ServiceOrderAttendance::signed($order->id, $staff->id)) {
//            return error_json('已签到过', 400);
//        }

        $attendance->forceFill([
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'service_order_id' => $order->id,
            'signin_time' => date('Y-m-d H:i:s'),
            'location' => $request->get('address'),
            'coordinate' => $request->get('lat') . ',' . $request->get('lng'),
            'remark' => json_encode($request->all())
        ])->save();

        return error_json('签到成功', 400);
    }
}
