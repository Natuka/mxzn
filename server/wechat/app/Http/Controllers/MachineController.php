<?php

namespace App\Http\Controllers;

use App\Models\CustomerEquipment;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function get($code = '', Request $request)
    {
        return redirect('/#/machine/info?id=' . $code );
    }

    /**
     * 获取机器信息
     * @param string $code
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info($code = '', Request $request)
    {
        $equipment = CustomerEquipment::findByQRCode($code);

//        $user = $this->user();
//
//        if (!$user->isCustomer()) {
//            return error_json('没有权限', 404);
//        }

        return success_json($equipment);
    }
}
