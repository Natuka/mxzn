<?php

namespace App\Http\Controllers\Admin\Machineqrcode;

use App\Http\Requests\Admin\Machineqrcode\CreateRequest;
use App\Http\Requests\Admin\Machineqrcode\UpdateRequest;
use App\Models\Code AS Machineqrcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Machineqrcode $machineqrcode)
    {
        $machineqrcode = $this->search($request, $machineqrcode);
        return success_json($machineqrcode->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Machineqrcode $machineqrcode)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $machineqrcode = $machineqrcode->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('model', 'like', '%'.$sch_value.'%')
                        ->orWhere('serial_number', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                $machineqrcode = $machineqrcode->where($sch_field, 'like', '%'.$sch_value.'%');
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $machineqrcode = $machineqrcode->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $machineqrcode;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Machineqrcode $machineqrcode)
    {
        $data = $request->only([
            'erp_itemid',
            'number',
            'name',
            'model',
            'brand',
            'stock_qty',
            'unit',
            'safety_stock_qty',
            'store',
            'price_ave',
            'price_pur1',
            'price_pur2',
            'price_pur3',
            'price_sale_unified',
            'price_sale_least',
            'price_sale1',
            'price_sale2',
            'price_sale3',
            'vendor',
            'remark',
            'syn_datetime',
        ]);
        $data['created_by'] = '新增';

        $data['syn_datetime'] = date('Y-m-d H:i:s', strtotime($data['syn_datetime']));
        //dd($data);
        $ret = $machineqrcode->forceFill($data)->save();

        if ($ret) {
            return success_json($machineqrcode, '');
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
     * @param  \App\Models\Machineqrcode  $machineqrcode
     * @return \Illuminate\Http\Response
     */
    public function show(Machineqrcode $machineqrcode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Machineqrcode  $machineqrcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Machineqrcode $machineqrcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Machineqrcode  $machineqrcode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Machineqrcode $machineqrcode)
    {
        $data = $request->only([
            'erp_itemid',
            'number',
            'name',
            'model',
            'brand',
            'stock_qty',
            'unit',
            'safety_stock_qty',
            'store',
            'price_ave',
            'price_pur1',
            'price_pur2',
            'price_pur3',
            'price_sale_unified',
            'price_sale_least',
            'price_sale1',
            'price_sale2',
            'price_sale3',
            'vendor',
            'remark',
            'syn_datetime',
        ]);
        $data['updated_by'] = '修改';
        $ret = $machineqrcode->forceFill($data)->save();

        if ($ret) {
            return success_json($machineqrcode, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Machineqrcode  $machineqrcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machineqrcode $machineqrcode)
    {
        $machineqrcode->delete();
        return success_json($machineqrcode, '删除成功');
    }
}
