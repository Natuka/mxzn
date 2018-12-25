<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerEquipment\CreateRequest;
use App\Http\Requests\Admin\CustomerEquipment\UpdateRequest;
use App\Models\Customer;
use App\Models\CustomerEquipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QrCode;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CustomerEquipment $customerequipment)
    {
        $customerequipment = $this->search($request, $customerequipment);
        return success_json($customerequipment->with(['customer' => function( $query ){
            $query->select(['id','name','name_short']);
        }])->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, CustomerEquipment $customerequipment)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $customerequipment = $customerequipment->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('model', 'like', '%'.$sch_value.'%')
                        ->orWhere('contract_number', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                if ($sch_field == 'cust_id') {
                    $customerequipment = $customerequipment->whereHas('customer', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%');
                    });
                }else{
                    $customerequipment = $customerequipment->where($sch_field, 'like', '%'.$sch_value.'%');
                }
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $customerequipment = $customerequipment->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $customerequipment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, CustomerEquipment $customerequipment)
    {
        $user = $request->user();
        $data = $request->only([
            'cust_id',
            'item_id',
            'name',
            'model',
            'type',
//            'code_id',
            'contract_number',
            'installation_staff',
            'technology_staff',
            'number',
            'sets',
            'main_no',
            'control_box_no',
            'main_model',
            'control_box_model',
            'welding_machine_no',
            'welding_machine_model',
            'axis1_no',
            'axis2_no',
            'axis3_no',
            'axis4_no',
            'axis5_no',
            'axis6_no',
            'code_chinese',
            'identification_code',
            'manufacture_date',
            'purchase_date',
            'installation_date',
            'acceptance_date',
            'warranty_date',
            'maintenance_times',
            'remark'
        ]);
        $data['dfrom'] = 0;
        $data['cust_id'] = (int)$data['cust_id'];
        $data['item_id'] = (int)$data['item_id'];
        $data['type'] = (int)$data['type'];
//        $data['code_id'] = (int)$data['code_id'];
        $data['maintenance_times'] = (int)$data['maintenance_times'];

        $data['manufacture_date'] = date('Y-m-d', strtotime($data['manufacture_date']));
        $data['purchase_date'] = date('Y-m-d', strtotime($data['purchase_date']));
        $data['installation_date'] = date('Y-m-d', strtotime($data['installation_date']));
        $data['acceptance_date'] = date('Y-m-d', strtotime($data['acceptance_date']));
        $data['warranty_date'] = date('Y-m-d', strtotime($data['warranty_date']));
        if (empty($data['manufacture_date']) || ($data['manufacture_date'] <= '1991-01-01')) $data['manufacture_date'] = NULL;
        if (empty($data['purchase_date']) || ($data['purchase_date'] <= '1991-01-01')) $data['purchase_date'] = NULL;
        if (empty($data['installation_date']) || ($data['installation_date'] <= '1991-01-01')) $data['installation_date'] = NULL;
        if (empty($data['acceptance_date']) || ($data['acceptance_date'] <= '1991-01-01')) $data['acceptance_date'] = NULL;
        if (empty($data['warranty_date']) || ($data['warranty_date'] <= '1991-01-01')) $data['warranty_date'] = NULL;

        $qrcode_key = 'CEQ'.md5(microtime());
        $data['qrcode_key'] = $qrcode_key;
        $data['qrcode_url'] = 'https://mp.mxhj.net/machine/'.$qrcode_key;
        $data['qrcode_img'] = 'qrcodes/'.$qrcode_key.'.png';
        //产生QRCODE
        QrCode::format('png')->size(300)->generate($data['qrcode_url'], public_path($data['qrcode_img']));

        $data['created_by'] = $user->userable_name;
        $data['updated_by'] = $user->userable_name;

        $ret = $customerequipment->forceFill($data)->save();

        if ($ret) {
            return success_json($customerequipment, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerEquipment  $customerequipment
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerEquipment $customerequipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerEquipment  $customerequipment
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerEquipment $customerequipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerEquipment  $customerequipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CustomerEquipment $customerequipment)
    {
        $user = $request->user();
        $data = $request->only([
            'cust_id',
            'item_id',
            'name',
            'model',
            'type',
//            'code_id',
            'contract_number',
            'installation_staff',
            'technology_staff',
            'number',
            'sets',
            'main_no',
            'control_box_no',
            'main_model',
            'control_box_model',
            'welding_machine_no',
            'welding_machine_model',
            'axis1_no',
            'axis2_no',
            'axis3_no',
            'axis4_no',
            'axis5_no',
            'axis6_no',
            'code_chinese',
            'identification_code',
            'manufacture_date',
            'purchase_date',
            'installation_date',
            'acceptance_date',
            'warranty_date',
            'maintenance_times',
            'remark'
        ]);
        $data['cust_id'] = (int)$data['cust_id'];
        $data['item_id'] = (int)$data['item_id'];
        $data['type'] = (int)$data['type'];
//        $data['code_id'] = (int)$data['code_id'];
        $data['maintenance_times'] = (int)$data['maintenance_times'];

        $data['manufacture_date'] = date('Y-m-d', strtotime($data['manufacture_date']));
        $data['purchase_date'] = date('Y-m-d', strtotime($data['purchase_date']));
        $data['installation_date'] = date('Y-m-d', strtotime($data['installation_date']));
        $data['acceptance_date'] = date('Y-m-d', strtotime($data['acceptance_date']));
        $data['warranty_date'] = date('Y-m-d', strtotime($data['warranty_date']));
        if (empty($data['manufacture_date']) || ($data['manufacture_date'] <= '1991-01-01')) $data['manufacture_date'] = NULL;
        if (empty($data['purchase_date']) || ($data['purchase_date'] <= '1991-01-01')) $data['purchase_date'] = NULL;
        if (empty($data['installation_date']) || ($data['installation_date'] <= '1991-01-01')) $data['installation_date'] = NULL;
        if (empty($data['acceptance_date']) || ($data['acceptance_date'] <= '1991-01-01')) $data['acceptance_date'] = NULL;
        if (empty($data['warranty_date']) || ($data['warranty_date'] <= '1991-01-01')) $data['warranty_date'] = NULL;

        $data['updated_by'] = $user->userable_name;
        if (empty($customerequipment->qrcode_key)) {
            $qrcode_key = 'CEQ'.md5(microtime());
            $data['qrcode_key'] = $qrcode_key;
            $data['qrcode_url'] = 'https://mp.mxhj.net/machine/'.$qrcode_key;
            $data['qrcode_img'] = 'qrcodes/'.$qrcode_key.'.png';
            //产生QRCODE
            QrCode::format('png')->size(300)->generate($data['qrcode_url'], public_path($data['qrcode_img']));
        }

        if ($customerequipment) {
            $ret = $customerequipment->forceFill($data)->save();

            if ($ret) {
                return success_json($customerequipment, '');
            }
        }
        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerEquipment  $customerequipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerEquipment $customerequipment)
    {
        $customerequipment->delete();
        return success_json($customerequipment, '删除成功');
    }
}
