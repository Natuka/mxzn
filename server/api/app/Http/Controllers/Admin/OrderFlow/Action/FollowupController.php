<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Followup\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Followup\UpdateRequest;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderFollowup;
use Illuminate\Http\Request;

class FollowupController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order, ServiceOrderFollowup $followup)
    {
        $followup = $this->search($request, $order, $followup);
        return success_json($followup->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, ServiceOrder $order, ServiceOrderFollowup $followup)
    {
        if ($order) {
            $followup = $followup->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $followup_number = $request->get('number', ''); // 客户编号
        $followup_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $followup = $followup->where('industry', (int)$industry);
        }
        if ($type) {
            $followup = $followup->where('type', (int)$type);
        }
        if ($level) {
            $followup = $followup->where('level', (int)$level);
        }
        if ($source) {
            $followup = $followup->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $followup = $followup->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($followup_number) {
            $followup = $followup->where('number', 'like', $followup_number . '%');
        }
        // 客户名称
        if ($followup_name) {
            $followup = $followup->where('name', 'like', '%' . $followup_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $followup = $followup->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $followup = $followup->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $followup;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, ServiceOrder $order, ServiceOrderFollowup $followup)
    {
        $data = $request->only([
            'followup_staff',
            'mobile',
            'handle_staff_id',
            'handle_staff_name',
            'handle_result',
            'remark',
        ]);
        $data['handle_staff_id'] = (int)$data['handle_staff_id'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $followup->forceFill($data)->save();

        if ($ret) {
            return success_json($followup, '');
        }

        return error_json('新增失败，请检查');

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, ServiceOrder $order, ServiceOrderFollowup $followup)
    {
        $data = $request->only([
            'followup_staff',
            'mobile',
            'handle_staff_id',
            'handle_staff_name',
            'handle_result',
            'remark',
        ]);
        $data['handle_staff_id'] = (int)$data['handle_staff_id'];

        $data['updated_by'] = '修改';

        $ret = $followup->forceFill($data)->save();

        if ($ret) {
            return success_json($followup, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $order, ServiceOrderFollowup $followup)
    {
        $followup->where('service_order_id', (int)$order['id'])->delete();
        return success_json($followup, '删除成功');
    }

}
