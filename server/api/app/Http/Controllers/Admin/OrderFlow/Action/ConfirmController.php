<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Confirm\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Confirm\UpdateRequest;

use App\Models\ServiceOrder;
use App\Models\ServiceOrderConfirm;
use Illuminate\Http\Request;

class ConfirmController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order, ServiceOrderConfirm $confirm)
    {
        $confirm = $this->search($request, $order, $confirm);
        return success_json($confirm->paginate(config('pageinfo.per_page')));
    }

    /**
     * 查询
     * @param Request $request
     * @param ServiceOrder $order
     * @param ServiceOrderConfirm $confirm
     * @return ServiceOrderConfirm
     */
    public function search(Request $request, ServiceOrder $order, ServiceOrderConfirm $confirm)
    {
        if ($order) {
            $confirm = $confirm->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $confirm_number = $request->get('number', ''); // 客户编号
        $confirm_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $confirm = $confirm->where('industry', (int)$industry);
        }
        if ($type) {
            $confirm = $confirm->where('type', (int)$type);
        }
        if ($level) {
            $confirm = $confirm->where('level', (int)$level);
        }
        if ($source) {
            $confirm = $confirm->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $confirm = $confirm->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($confirm_number) {
            $confirm = $confirm->where('number', 'like', $confirm_number . '%');
        }
        // 客户名称
        if ($confirm_name) {
            $confirm = $confirm->where('name', 'like', '%' . $confirm_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $confirm = $confirm->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $confirm = $confirm->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $confirm;
    }


    /**
     * 创建
     * @param CreateRequest $request
     * @param ServiceOrder $order
     * @param ServiceOrderConfirm $confirm
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request, ServiceOrder $order, ServiceOrderConfirm $confirm)
    {
        $data = $request->only([
            'is_solve',
            'overall_satisfaction',
            'timeliness',
            'service_staff_atisfaction',
            'cost_performance',
            'confirm_user_id',
            'confirm_user_name',
            'opinions_suggestions',
        ]);
        $data['is_solve'] = (int)$data['is_solve'];
        $data['overall_satisfaction'] = (int)$data['overall_satisfaction'];
        $data['timeliness'] = (int)$data['timeliness'];
        $data['service_staff_atisfaction'] = (int)$data['service_staff_atisfaction'];
        $data['cost_performance'] = (int)$data['cost_performance'];
        $data['confirm_user_id'] = (int)$data['confirm_user_id'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $confirm->forceFill($data)->save();

        if ($ret) {
            return success_json($confirm, '');
        }

        return error_json('新增失败，请检查');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ServiceOrder $order, ServiceOrderConfirm $confirm)
    {
        $data = $request->only([
            'is_solve',
            'overall_satisfaction',
            'timeliness',
            'service_staff_atisfaction',
            'cost_performance',
            'confirm_user_id',
            'confirm_user_name',
            'opinions_suggestions',
        ]);
        $data['is_solve'] = (int)$data['is_solve'];
        $data['overall_satisfaction'] = (int)$data['overall_satisfaction'];
        $data['timeliness'] = (int)$data['timeliness'];
        $data['service_staff_atisfaction'] = (int)$data['service_staff_atisfaction'];
        $data['cost_performance'] = (int)$data['cost_performance'];
        $data['confirm_user_id'] = (int)$data['confirm_user_id'];

        $data['updated_by'] = '修改';

        $ret = $confirm->forceFill($data)->save();

        if ($ret) {
            return success_json($confirm, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $order, ServiceOrderConfirm $confirm)
    {
        $confirm->where('service_order_id', (int)$order['id'])->delete();
        return success_json($confirm, '删除成功');
    }

}
