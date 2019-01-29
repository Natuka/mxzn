<?php

namespace App\Http\Controllers\Equipment;

use App\Models\CustomerEquipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerEquipment\CreateRequest;
use App\Http\Requests\CustomerEquipment\UpdateRequest;
use App\Models\Customer;

class IndexController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = $this->user();

        if (!$user->isCustomer) {
            return success_json([]);
        }

        if (!$user->info || !$user->info->customer) {
            return success_json([]);
        }

        $customer = $user->info->customer;

        $list = CustomerEquipment::where('cust_id', $customer->id);
        $limitId = (int)$request->get('id', 0);
        if ($limitId > 0) {
            $list = $list->where('id', $limitId);
            $list = $list->first();
            return success_json($list);
        }
        $list = $list->limit(30)->get();

        return success_json($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, CustomerEquipment $customerequipment)
    {
        $user = $this->user();
        $customer = $this->customer();
        if (!$customer) {
            return error_json('没有权限建立设备');
        }

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
        $data['dfrom'] = 1;
        $data['cust_id'] = (int)$customer->id;
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
}
