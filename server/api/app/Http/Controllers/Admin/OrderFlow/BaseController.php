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
        $type = $request->get('schType', 0); //工单类别
        // 服务类别
        if ($type) {
            $order = $order->where('type', $type);
        }
        $degree = $request->get('schDegree', 0); //紧急程度
        if ($degree) {
            $order = $order->where('emergency_degree', $degree);
        }
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        $order = $this->where_group($sch_field, $sch_value, $order);
        $sch_field = $request->get('schField2', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue2', ''); //查询字段或模糊查询
        $order = $this->where_group($sch_field, $sch_value, $order);
        $sch_field = $request->get('schField3', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue3', ''); //查询字段或模糊查询
        $order = $this->where_group($sch_field, $sch_value, $order);

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

        //排序
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序
        $orderFieldArray = array('0'=>'id');
        $orderByArray = array('0'=>'ASC', '1'=>'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])){
            $order = $order->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }

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

    /**
     * 查询
     * @param  [type] $request        [description]
     * @param  [type] $order         [description]
     * @return [type]                 [description]
     */
    public function where_group($sch_field, $sch_value, $order)
    {
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $order = $order->where(function($query) use($sch_field, $sch_value)
                {
                    $query = $query->where('number', 'like', '%'.$sch_value.'%');
                    $query = $query->orWhere(function($query) use($sch_field, $sch_value)
                    {
                        $query = $query->whereHas('customer', function ($query) use ($sch_value) {
                            $query->where('name', 'like', '%'.$sch_value.'%');
                        });
                    });
                    $query = $query->orWhere(function($query) use($sch_field, $sch_value)
                    {
                        $query = $query->whereHas('feedbackStaff', function ($query) use ($sch_value) {
                            $query->where('name', 'like', '%'.$sch_value.'%');
                        });
                    });
                    $query = $query->orWhere(function($query) use($sch_field, $sch_value)
                    {
                        $query = $query->whereHas('receive_staff', function ($query) use ($sch_value) {
                            $query->where('name', 'like', '%'.$sch_value.'%');
                        });
                    });
                    $query = $query->orWhere(function($query) use($sch_field, $sch_value)
                    {
                        $query = $query->whereHas('engineers', function ($query) use ($sch_value) {
                            $query->where('staff_name', 'like', '%'.$sch_value.'%');
                        });
                    });
                    $query = $query->orWhere(function($query) use($sch_field, $sch_value)
                    {
                        $query = $query->whereHas('fault', function ($query) use ($sch_value) {
                            $query->where('desc', 'like', '%'.$sch_value.'%');
                        });
                    });

                });
            }else{
                if (in_array($sch_field, ['number'])) {
                    $order = $order->where($sch_field, 'like', '%'.$sch_value.'%');
                }else {
                    switch ($sch_field) {
                        case 'customer_name' :
                            $order = $order->whereHas('customer', function ($query) use ($sch_value) {
                                $query->where('name', 'like', '%'.$sch_value.'%');
                            });
                            break;
                        case 'feedback_staff' :
                            $order = $order->whereHas('feedbackStaff', function ($query) use ($sch_value) {
                                $query->where('name', 'like', '%'.$sch_value.'%');
                            });
                            break;
                        case 'receive_staff' :
                            $order = $order->whereHas('receiveStaff', function ($query) use ($sch_value) {
                                $query->where('name', 'like', '%'.$sch_value.'%');
                            });
                            break;
                        case 'engineer' :
                            $order = $order->whereHas('engineers', function ($query) use ($sch_value) {
                                $query->where('staff_name', 'like', '%'.$sch_value.'%');
                            });
                            break;
                        case 'fault_desc' :
                            $order = $order->whereHas('fault', function ($query) use ($sch_value) {
                                $query->where('desc', 'like', '%'.$sch_value.'%');
                            });
                            break;
                        default:break;
                    }
                }

            }
        }

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
