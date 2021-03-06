<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Service\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Service\UpdateRequest;
use App\Models\ServiceOrderService;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order, ServiceOrderService $service)
    {
        $service = $this->search($request, $order, $service);
        return success_json($service->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, ServiceOrder $order, ServiceOrderService $service)
    {
        if ($order) {
            $service = $service->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $service_number = $request->get('number', ''); // 客户编号
        $service_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $service = $service->where('industry', (int)$industry);
        }
        if ($type) {
            $service = $service->where('type', (int)$type);
        }
        if ($level) {
            $service = $service->where('level', (int)$level);
        }
        if ($source) {
            $service = $service->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $service = $service->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($service_number) {
            $service = $service->where('number', 'like', $service_number . '%');
        }
        // 客户名称
        if ($service_name) {
            $service = $service->where('name', 'like', '%' . $service_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $service = $service->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $service = $service->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $service;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, ServiceOrder $order, ServiceOrderService $service)
    {
        $user = $request->user();
        $data = $request->only([
            'service_id',
            'name',
            'content',
            'workday',
            'area',
            'price',
            'unit',
            'quantity',
            'amount',
            'reward',
            'is_land_traffic',
            'is_hotel',
            'settlement_method',
            'working_hours',
            'is_complete',
            'staff_id',
            'staff_name',
            'remark',
        ]);
        $data['service_id'] = (int)$data['service_id'];
        $data['price'] = doubleval($data['price']);
        $data['quantity'] = (int)$data['quantity'];
        $data['settlement_method'] = (int)$data['settlement_method'];
        $data['is_complete'] = (int)$data['is_complete'];
        $data['staff_id'] = (int)$data['staff_id'];
        $data['amount'] = doubleval($data['amount']);
        $data['reward'] = doubleval($data['reward']);
        $data['working_hours'] = doubleval($data['working_hours']);
        $data['is_land_traffic'] = (int)$data['is_land_traffic'];
        $data['is_hotel'] = (int)$data['is_hotel'];

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = $user->userable_name;
        $data['updated_by'] = $user->userable_name;

        $ret = $service->forceFill($data)->save();

        if ($ret) {
            return success_json($service, '');
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
    public function update(UpdateRequest $request, ServiceOrder $order, ServiceOrderService $service)
    {
        $user = $request->user();
        $data = $request->only([
            'service_id',
            'name',
            'content',
            'workday',
            'area',
            'price',
            'unit',
            'quantity',
            'amount',
            'reward',
            'is_land_traffic',
            'is_hotel',
            'settlement_method',
            'working_hours',
            'is_complete',
            'staff_id',
            'staff_name',
            'remark',
        ]);
        $data['service_id'] = (int)$data['service_id'];
        $data['price'] = doubleval($data['price']);
        $data['quantity'] = (int)$data['quantity'];
        $data['settlement_method'] = (int)$data['settlement_method'];
        $data['is_complete'] = (int)$data['is_complete'];
        $data['staff_id'] = (int)$data['staff_id'];
        $data['amount'] = doubleval($data['amount']);
        $data['reward'] = doubleval($data['reward']);
        $data['working_hours'] = doubleval($data['working_hours']);
        $data['is_land_traffic'] = (int)$data['is_land_traffic'];
        $data['is_hotel'] = (int)$data['is_hotel'];

        $data['updated_by'] = $user->userable_name;

        $ret = $service->forceFill($data)->save();

        if ($ret) {
            return success_json($service, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceOrder $order, ServiceOrderService $service)
    {
        $service->where('service_order_id', (int)$order['id'])->delete();
        return success_json($service, '删除成功');
    }

}
