<?php

namespace App\Http\Controllers\Order;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // 单据状态: 制单中 0, 已受理 1,待派单 2,处理中 3,已取消 4,已关闭 5,无法处理 6
    public function index(Request $request)
    {
        $type = +$request->get('type', 0);

        $builder = ServiceOrder::with([
            'fault',
            'documents',
            'customer',
            'engineers',
            'feedbackStaff',
            'receiveStaff',
            'confirmStaff',
        ])->orderBy('id', 'desc');

        if ($type === 1) {
            // 待处理
            $builder = $builder->whereIn('status', [0, 1, 2])->where('cancel_status', 0);
        } else if ($type === 2) {
            // 处理中
            $builder = $builder->whereIn('status', [3])
                ->where('cancel_status', 0);
        } else if ($type === 3) {
            // 待结算
            $builder = $builder->whereIn('status', [5])
                ->where('settle_status', 0)
                ->where('cancel_status', 0);
        } else if ($type === 4) {
            // 已完成
            $builder = $builder->whereIn('status', [5])
                ->where('settle_status', 1)
                ->where('cancel_status', 0);
        }

        $data = $builder->paginate();

        return success_json($data);
    }

    // 单据状态: 制单中 0, 已受理 1,待派单 2,处理中 3,已取消 4,已关闭 5,无法处理 6
    public function get($order, Request $request)
    {
        $builder = ServiceOrder::with([
            'fault',
            'documents',
            'customer',
            'engineers',
            'feedbackStaff',
            'receiveStaff',
            'confirmStaff',
        ])->where('id', $order);

        return success_json($builder->first());
    }


}
