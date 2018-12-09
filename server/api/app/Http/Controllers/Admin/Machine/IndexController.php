<?php

namespace App\Http\Controllers\Admin\Machine;

use App\Http\Requests\Admin\Machine\CreateRequest;
use App\Http\Requests\Admin\Machine\UpdateRequest;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Machine $machine)
    {
        $machine = $this->search($request, $machine);
        return success_json($machine->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Machine $machine)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $machine = $machine->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('model', 'like', '%'.$sch_value.'%')
                        ->orWhere('brand', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                $machine = $machine->where($sch_field, 'like', '%'.$sch_value.'%');
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $machine = $machine->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $machine;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Machine $machine)
    {
        $user = $request->user();
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
        $data['created_by'] = $user->userable_name;

        $data['syn_datetime'] = date('Y-m-d H:i:s', strtotime($data['syn_datetime']));
        if (empty($data['syn_datetime']) || ($data['syn_datetime'] <= '1991-01-01 00:00:00')) $data['syn_datetime'] = NULL;

        //dd($data);
        $ret = $machine->forceFill($data)->save();

        if ($ret) {
            return success_json($machine, '');
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
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Machine $machine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function edit(Machine $machine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Machine $machine)
    {
        $user = $request->user();
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
        $data['updated_by'] = $user->userable_name;

        $data['syn_datetime'] = date('Y-m-d H:i:s', strtotime($data['syn_datetime']));
        if (empty($data['syn_datetime']) || ($data['syn_datetime'] <= '1991-01-01 00:00:00')) $data['syn_datetime'] = NULL;


        $ret = $machine->forceFill($data)->save();

        if ($ret) {
            return success_json($machine, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return success_json($machine, '删除成功');
    }
}
