<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Repairs\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Repairs\UpdateRequest;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderRepair;
use Illuminate\Http\Request;

class RepairsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
        $repair = $this->search($request, $order, $repair);
        return success_json($repair->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
        if ($order) {
            $repair = $repair->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $repair_number = $request->get('number', ''); // 客户编号
        $repair_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $repair = $repair->where('industry', (int)$industry);
        }
        if ($type) {
            $repair = $repair->where('type', (int)$type);
        }
        if ($level) {
            $repair = $repair->where('level', (int)$level);
        }
        if ($source) {
            $repair = $repair->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $repair = $repair->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($repair_number) {
            $repair = $repair->where('number', 'like', $repair_number . '%');
        }
        // 客户名称
        if ($repair_name) {
            $repair = $repair->where('name', 'like', '%' . $repair_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $repair = $repair->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $repair = $repair->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $repair;
    }


    /**
     * @param CreateRequest $request
     * @param ServiceOrder $order
     * @param ServiceOrderRepair $repair
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
        $data = $request->only([
            'staff_id',
            'staff_name',
            'process_id',
            'process',
            'step_result',
            'step_doc_ids',
            'arrived_at',
            'complete_at',
            'cause_id',
            'cause',
            'cause_doc_ids',
            'next_step',
        ]);
        $data['staff_id'] = (int)$data['staff_id'];
        $data['process_id'] = (int)$data['process_id'];
        $data['cause_id'] = (int)$data['cause_id'];
        $data['arrived_at'] = format_date($data['arrived_at']);
        $data['complete_at'] = format_date($data['complete_at']);
        $data['next_step'] = (int)$data['next_step'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $repair->forceFill($data)->save();

        if ($ret) {
            $this->saveDocWithType($order, 1, $repair->step_doc_ids);
            $this->saveDocWithType($order, 2, $repair->cause_doc_ids);

            /*          下步处理，选择完工关闭，工单状态修改为：待结算
            下步处理，选择暂不关闭，工单状态不变：处理中
            下步处理，选择内部派工，工单状态不变：处理中，通知新的服务工程师处理
            下步处理，选择派给网点，工单状态不变：处理中，通知新的服务工程师处理*/
            if ($data['next_step'] ==1) {
//                下步处理，选择完工关闭，工单状态修改为：待结算
                if ($order) {
                    //$this->assignToContact($info['id'], $user->id);
                    $save_data['status'] = 4;
                    //$data['progress_time'] = date('Y-m-d H:i:s', time());
                    $order->forceFill($save_data)->save();
                }
            }elseif ($data['next_step'] ==2 || $data['next_step'] ==3) {
//                TODO 通知新的服务工程师处理

            }

            return success_json($repair, '');
        }

        return error_json('新增失败，请检查');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ServiceOrder $order, ServiceOrderRepair $repair)
    {
/*       \Log::info([
                'next next' => $repair
        ]);*/
        $data = $request->only([
            'staff_id',
            'staff_name',
            'process_id',
            'process',
            'step_result',
            'step_doc_ids',
            'arrived_at',
            'complete_at',
            'cause_id',
            'cause',
            'cause_doc_ids',
            'next_step',
        ]);
        $data['staff_id'] = (int)$data['staff_id'];
        $data['process_id'] = (int)$data['process_id'];
        $data['cause_id'] = (int)$data['cause_id'];
        $data['arrived_at'] = format_date($data['arrived_at']);
        $data['complete_at'] = format_date($data['complete_at']);

        $data['updated_by'] = '修改';

        $ret = $repair->forceFill($data)->save();

        if ($ret) {
            $this->saveDocWithType($order, 1, $repair->step_doc_ids);
            $this->saveDocWithType($order, 2, $repair->cause_doc_ids);

/*          下步处理，选择完工关闭，工单状态修改为：待结算
            下步处理，选择暂不关闭，工单状态不变：处理中
            下步处理，选择内部派工，工单状态不变：处理中，通知新的服务工程师处理
            下步处理，选择派给网点，工单状态不变：处理中，通知新的服务工程师处理*/
            if ($data['next_step'] ==1) {
//                下步处理，选择完工关闭，工单状态修改为：待结算
                if ($order) {
                    //$this->assignToContact($info['id'], $user->id);
                    $save_data['status'] = 4;
                    //$data['progress_time'] = date('Y-m-d H:i:s', time());
                    $order->forceFill($save_data)->save();
                }
            }elseif ($data['next_step'] ==2 || $data['next_step'] ==3) {
//                TODO 通知新的服务工程师处理

            }

            return success_json($repair, '');
        }

        return error_json('修改失败，请检查');
    }

    public function saveDocWithType(ServiceOrder $order, $type = 1, $ids = '')
    {
        if (!$ids) {
            $ids = [];
        } else {
            $ids = explode(',', $ids);
        }

        $ret = [];
        foreach ($ids as $id) {
            $ret[$id] = [
                'type' => $type,
            ];
        }

        $order->documents($type)->withTimestamps()->sync($ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $order, ServiceOrderRepair $repair)
    {
        $repair->where('service_order_id', (int)$order['id'])->delete();
        return success_json($repair, '删除成功');
    }

}
