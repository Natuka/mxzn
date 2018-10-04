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
        return $machine;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Machine $machine)
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
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
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
