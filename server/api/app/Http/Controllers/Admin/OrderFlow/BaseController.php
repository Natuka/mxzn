<?php

namespace App\Http\Controllers\Admin\OrderFlow;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BaseController extends Controller
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
    protected $type = 0;

    /**
     * 服务类别对应的代号
     * @var string
     */
    protected $typeWord = '';

    /**
     * 每页20
     * @var integer
     */
    protected $perPage = 20;

    protected $order = null;

    protected $request = null;

    protected $user_id = 0;

    const USER_OK = 0;

    public function __construct(Request $request, ServiceOrder $order)
    {
        $this->request = $request;
        $this->order = $order;
        //
        //$this->user_id = admin_id();
    }

    /**
     * 查询
     * @param  [type] $request        [description]
     * @param  [type] $order         [description]
     * @return [type]                 [description]
     */
    public function where(Request $request, ServiceOrder $order)
    {
        $type = $request->get('type', 0); //服务类别
        $orderField = $request->get('orderField', 3); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

/*        $start_date = $request->get('start_date', '');
        $end_date = $request->get('end_date', '');

        if (!empty($start_date) && !empty($end_date)) {
            $dateField = '';
            if (4 == $this->progress) {
                $dateField = 'progress_date';
            }elseif (8 == $this->progress) {
                $dateField = 'retracing_date';
            }
            if (!empty($dateField)) {
                $order = $order->whereNotNull($dateField);
                $order = $order->where($dateField, '>=', $start_date);
                $order = $order->where($dateField, '<', $end_date);
            }
        }*/


        // 服务类别
        if ($type) {
            $order = $order->where('type', $type);
        }

        //已过期
/*        if ($request->get('report_overdue', 0)) {
            $order = $order->where('progress_date', '<', carbon(null)->toDateString());
        }*/

        //排序
//        $orderFieldArray = array('0'=>'name', '1'=>'acct', '2'=>'birth', '3'=>'progress_time', '4'=>'id','5'=>'progress_date','6'=>'business_man');
//        $orderByArray = array('0'=>'ASC', '1'=>'DESC',);
//        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])){
//            $order = $order->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
//        }

        $order = $order->with([
            'fault',
            'documents',
            'customer',
            'engineers',
            'feedbackStaff',
            'receiveStaff',
            'confirmStaff',
        ]);

        return $order;
    }

    public function getList(Request $request, ServiceOrder $order)
    {
        $order = $this->where($request, $order);
        if (0 < $this->type) {
          $order = $order->where('type', $this->type);
        }

        $ret = $order->where('status', $this->status)
            ->paginate($this->perPage);
        // 渲染
        return $this->renderResource($ret);
    }

    /**
     * 默认渲染
     * @param  [type] $list [description]
     * @return [type]       [description]
     */
    public function renderResource($list)
    {
        return $list;
    }

    /**
     * 工单编号,R1809-0001,R+年份2码+月份2码+流水码4码
     * @return string
     */
    public function createNumber()
    {
        $prefix = sprintf('%s%s', $this->typeWord, date('ym'));
        return ServiceOrder::createNumber($prefix);
    }
}
