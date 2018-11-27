<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerEquipment\CreateRequest;
use App\Http\Requests\Admin\CustomerEquipment\UpdateRequest;
use App\Models\Customer;
use App\Models\CustomerEquipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CustomerEquipment $customerEquipment)
    {
        $customerEquipment = $this->search($request, $customerEquipment);
        return success_json($customerEquipment->with(['customer' => function( $query ){
            $query->select(['id','name']);
        }])->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, CustomerEquipment $customerEquipment)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $customerEquipment = $customerEquipment->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('model', 'like', '%'.$sch_value.'%')
                        ->orWhere('contract_number', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                if ($sch_field == 'cust_id') {
                    $customerEquipment = $customerEquipment->whereHas('customer', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%');
                    });
                }else{
                    $customerEquipment = $customerEquipment->where($sch_field, 'like', '%'.$sch_value.'%');
                }
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $customerEquipment = $customerEquipment->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $customerEquipment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, CustomerEquipment $customerEquipment)
    {
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
        $data['qrcode_url'] = 'https://api.mxcs.com/machine/'.$qrcode_key;

        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $customerEquipment->forceFill($data)->save();

        if ($ret) {
            return success_json($customerEquipment, '');
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
     * @param  \App\Models\CustomerEquipment  $customerEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerEquipment $customerEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerEquipment  $customerEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerEquipment $customerEquipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerEquipment  $customerEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CustomerEquipment $customerEquipment)
    {
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

        $data['updated_by'] = '修改';
        $ret = $customerEquipment->forceFill($data)->save();

        if ($ret) {
            return success_json($customerEquipment, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerEquipment  $customerEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerEquipment $customerEquipment)
    {
        $customerEquipment->delete();
        return success_json($customerEquipment, '删除成功');
    }
}
