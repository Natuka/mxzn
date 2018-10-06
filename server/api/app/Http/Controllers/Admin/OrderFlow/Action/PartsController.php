<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Parts\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Parts\UpdateRequest;
use App\Models\Order;
use App\Models\ServiceOrderPart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Order $order, ServiceOrderPart $part)
    {
        $part = $this->search($request, $order, $part);
        return success_json($part->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, Order $order, ServiceOrderPart $part)
    {
        if ($order) {
            $part = $part->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $part_number = $request->get('number', ''); // 客户编号
        $part_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $part = $part->where('industry', (int)$industry);
        }
        if ($type) {
            $part = $part->where('type', (int)$type);
        }
        if ($level) {
            $part = $part->where('level', (int)$level);
        }
        if ($source) {
            $part = $part->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $part = $part->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($part_number) {
            $part = $part->where('number', 'like', $part_number . '%');
        }
        // 客户名称
        if ($part_name) {
            $part = $part->where('name', 'like', '%' . $part_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $part = $part->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $part = $part->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $part;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Order $order, ServiceOrderPart $part)
    {
        $data = $request->only([
            'base_part_id',
            'base_code_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'amount_dis',
            'warranty_months',
            'warranty_date',
        ]);
        //$request['source'] = $request->get('source', 3);

        $data['base_part_id'] = (int)$data['base_part_id'];
        $data['base_code_id'] = (int)$data['base_code_id'];
        $data['warranty_months'] = (int)$data['warranty_months'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['warranty_date'] = format_date($data['warranty_date']);

        $data['service_order_id'] = (int)$order['id'];
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $part->forceFill($data)->save();

        if ($ret) {
            return success_json($part, '');
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
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Order $order, ServiceOrderPart $part)
    {
        $data = $request->only([
            'base_part_id',
            'base_code_id',
            'number',
            'name',
            'model',
            'unit',
            'quantity',
            'price',
            'amount',
            'discount',
            'amount_dis',
            'warranty_months',
            'warranty_date',
        ]);
        //$request['source'] = $request->get('source', 3);

        $data['base_part_id'] = (int)$data['base_part_id'];
        $data['base_code_id'] = (int)$data['base_code_id'];
        $data['warranty_months'] = (int)$data['warranty_months'];
        $data['quantity'] = doubleval($data['quantity']);
        $data['price'] = doubleval($data['price']);
        $data['amount'] = doubleval($data['amount']);
        $data['discount'] = doubleval($data['discount']);
        $data['warranty_date'] = format_date($data['warranty_date']);

        $data['updated_by'] = '修改';

        $ret = $part->forceFill($data)->save();

        if ($ret) {
            return success_json($part, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, ServiceOrderPart $part)
    {
        $part->where('service_order_id', (int)$order['id'])->delete();
        return success_json($part, '删除成功');
    }
    
}
