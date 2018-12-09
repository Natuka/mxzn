<?php

namespace App\Http\Controllers\Admin\Machineqrcode;

use App\Http\Requests\Admin\Machineqrcode\CreateRequest;
use App\Http\Requests\Admin\Machineqrcode\UpdateRequest;
use App\Models\Code AS Machineqrcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QrCode;

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
    public function store(CreateRequest $request, Machineqrcode $machineqrcode)
    {
        $user = $request->user();
        $data = $request->only([
            'number',
            'name',
            'model',
            'manufacture_date',
            'purchase_date',
            'serial_number',
            'remark'
        ]);
        $data['created_by'] = $user->userable_name;

        $data['manufacture_date'] = date('Y-m-d', strtotime($data['manufacture_date']));
        $data['purchase_date'] = date('Y-m-d', strtotime($data['purchase_date']));
        if (empty($data['manufacture_date']) || ($data['manufacture_date'] <= '1991-01-01')) $data['manufacture_date'] = NULL;
        if (empty($data['purchase_date']) || ($data['purchase_date'] <= '1991-01-01')) $data['purchase_date'] = NULL;
        //dd($data);
        $qrcode_key = 'MAC'.md5(microtime());
        $data['qrcode_key'] = $qrcode_key;
        $data['qrcode_url'] = 'https://wx.mxhj.com/machine/'.$qrcode_key;
        $data['qrcode_img'] = 'qrcodes/'.$qrcode_key.'.png';
        //产生QRCODE
        QrCode::format('png')->size(300)->generate($data['qrcode_url'], public_path($data['qrcode_img']));


        $ret = $machineqrcode->forceFill($data)->save();

        if ($ret) {
            return success_json($machineqrcode, '');
        }

        return error_json('新增失败，请检查');
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
        $user = $request->user();
        $data = $request->only([
            'number',
            'name',
            'model',
            'manufacture_date',
            'purchase_date',
            'serial_number',
            'remark'
        ]);
        $data['updated_by'] = $user->userable_name;

        $data['manufacture_date'] = date('Y-m-d', strtotime($data['manufacture_date']));
        $data['purchase_date'] = date('Y-m-d', strtotime($data['purchase_date']));
        if (empty($data['manufacture_date']) || ($data['manufacture_date'] <= '1991-01-01')) $data['manufacture_date'] = NULL;
        if (empty($data['purchase_date']) || ($data['purchase_date'] <= '1991-01-01')) $data['purchase_date'] = NULL;

        if (empty($machineqrcode->qrcode_key)) {
            $qrcode_key = 'MAC'.md5(microtime());
            $data['qrcode_key'] = $qrcode_key;
            $data['qrcode_url'] = 'https://wx.mxhj.com/machine/'.$qrcode_key;
            $data['qrcode_img'] = 'qrcodes/'.$qrcode_key.'.png';
            //产生QRCODE
            QrCode::format('png')->size(300)->generate($data['qrcode_url'], public_path($data['qrcode_img']));
        }

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
