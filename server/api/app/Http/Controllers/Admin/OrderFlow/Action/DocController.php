<?php

namespace App\Http\Controllers\Admin\OrderFlow\Action;

use App\Http\Requests\Admin\OrderAction\Doc\CreateRequest;
use App\Http\Requests\Admin\OrderAction\Doc\UpdateRequest;
use App\Models\Order;
use App\Models\ServiceOrderDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ServiceOrder $order, ServiceOrderDocument $doc)
    {
        $doc = $this->search($request, $order, $doc);
        return success_json($doc->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, ServiceOrder $order, ServiceOrderDocument $doc)
    {
        if ($order) {
            $doc = $doc->where('service_order_id', (int)$order['id']);
        }

        /*$industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $doc_number = $request->get('number', ''); // 客户编号
        $doc_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序

        if ($industry) {
            $doc = $doc->where('industry', (int)$industry);
        }
        if ($type) {
            $doc = $doc->where('type', (int)$type);
        }
        if ($level) {
            $doc = $doc->where('level', (int)$level);
        }
        if ($source) {
            $doc = $doc->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $doc = $doc->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($doc_number) {
            $doc = $doc->where('number', 'like', $doc_number . '%');
        }
        // 客户名称
        if ($doc_name) {
            $doc = $doc->where('name', 'like', '%' . $doc_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $doc = $doc->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $doc = $doc->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }*/
        return $doc;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, ServiceOrder $order, ServiceOrderDocument $doc)
    {
        $data = $request->only([
            'document_id',
        ]);
        $data['document_id'] = (int)$data['document_id'];

        $data['service_order_id'] = (int)$order['id'];

        /*        $data['created_by'] = '新增';
                $data['updated_by'] = '新增';*/

        $ret = $doc->forceFill($data)->save();

        if ($ret) {
            return success_json($doc, '');
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
    public function update(UpdateRequest $request, ServiceOrder $order, ServiceOrderDocument $doc)
    {
        $data = $request->only([
            'document_id',
        ]);
        $data['document_id'] = (int)$data['document_id'];
        //$data['updated_by'] = '修改';

        $ret = $doc->forceFill($data)->save();

        if ($ret) {
            return success_json($doc, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, ServiceOrderDocument $doc)
    {
        $doc->where('service_order_id', (int)$order['id'])->delete();
        return success_json($doc, '删除成功');
    }


}
