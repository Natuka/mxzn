<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\Customer\CreateRequest;
use App\Http\Requests\Admin\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Customer $customer)
    {
        //
        $customer = $this->search($request, $customer);
        return success_json($customer->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, Customer $customer)
    {
        $industry = $request->get('industry', 0); //所属行业
        $type = $request->get('type', 0); //客户类别
        $level = $request->get('level', 0); //客户级别
        $source = $request->get('source', 0); //客户来源
        $follow_up_status = $request->get('follow_up_status', 0); //跟进状态
        $customer_number = $request->get('number', ''); // 客户编号
        $customer_name = $request->get('name', ''); // 客户名称
        $short_name = $request->get('name_short', ''); // 客户简称
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 1); // 排序顺序
        // 在查寻功能时没有强制必选
        /*        $layerid = $request->input('layerid', 0);
                if ($layerid) {
                    //判断对应的层级,查询条件是否满足
                    if (($layerid == 1) || ($layerid == 2 && $typeId)){

                    }else{
                        return $customer->whereRaw('0');
                    }
                }*/
        // 在派遣时是哟经参数 with_params
        /*        $withParams = $request->input('with_params', 0);
                // 采用类别时，强制是哟经类型搜寻
                if ($withType) {
                    $customer = $customer->where('customer_type_id', (int) $typeId);
                } else {
                    // 客户类型
                    if ($customer_type_id) {
                        $customer = $customer->where('customer_type_id', $customer_type_id);
                    }elseif ($typeId) {
                        $customer = $customer->where('customer_type_id', (int) $typeId);
                    }
                }*/

        if ($industry) {
            $customer = $customer->where('industry', (int)$industry);
        }
        if ($type) {
            $customer = $customer->where('type', (int)$type);
        }
        if ($level) {
            $customer = $customer->where('level', (int)$level);
        }
        if ($source) {
            $customer = $customer->where('source', (int)$source);
        }
        if ($follow_up_status) {
            $customer = $customer->where('follow_up_status', (int)$follow_up_status);
        }
        // 公司编号
        if ($customer_number) {
            $customer = $customer->where('number', 'like', $customer_number . '%');
        }
        // 客户名称
        if ($customer_name) {
            $customer = $customer->where('name', 'like', '%' . $customer_name . '%');
        }
        // 公司简称
        if ($short_name) {
            $customer = $customer->where('name_short', 'like', '%' . $short_name . '%');
        }

        $orderFieldArray = array('0' => 'number', '1' => 'name', '2' => 'industry', '3' => 'type', '4' => 'level', '5' => 'follow_up_status', '6' => 'source');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {

            $customer = $customer->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $customer;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Customer $customer)
    {
        $data = $request->only([
            'erp_cust_id',
            'name',
            'name_short',
            'industry',
            'type',
            'level',
            'follow_up_status',
            'source',
            'staff_scale',
            'purchasing_power',
            'follow_up_nexttime',
            'contact_lasttime',
            'province_id',
            'city_id',
            'district_county_id',
            'address',
            'tel',
            'fax',
            'zip_code',
            'salesman_id',
            'ent_code',
            'bank',
            'account',
            'remark',
            'blacklist',
            'status',
            'syn_datetime',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';
        $data['number'] = Customer::customerCode(date('Y-m-d')); //(系统自动编号)

        $data['follow_up_nexttime'] = date('Y-m-d H:i:s', strtotime($data['follow_up_nexttime']));
        $data['contact_lasttime'] = date('Y-m-d H:i:s', strtotime($data['contact_lasttime']));
        $data['syn_datetime'] = date('Y-m-d H:i:s', strtotime($data['syn_datetime']));

        $ret = $customer->forceFill($data)->save();

        if ($ret) {
            $this->createLoginAccount($customer, $request);
            return success_json($customer, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * 创建登录账号
     * @param Customer $customer
     * @param Request $request
     */
    public function createLoginAccount(Customer $customer, Request $request)
    {
        $data = [
            'name' => $customer->name,
            'code' => $customer->number,
            'email' => $customer->number . '@mxcs.com',
            'number' => $customer->number,
            'mobile' => (int)$customer->tel,
            'qq' => '0',
            'wechat' => '',
            'valid' => 1,
            'password' => bcrypt($request->get('password', default_password())),
        ];

        if ($customer->user()->create($data)) {
            \Log::info('用户创建成功');
        } else {
            \Log::info('用户创建失败');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
//        dd($request->getContent(), $request->all());
        $data = $request->only([
            'erp_cust_id',
            'name',
            'name_short',
            'industry',
            'type',
            'level',
            'follow_up_status',
            'source',
            'staff_scale',
            'purchasing_power',
            'follow_up_nexttime',
            'contact_lasttime',
            'province_id',
            'city_id',
            'district_county_id',
            'address',
            'tel',
            'fax',
            'zip_code',
            'salesman_id',
            'ent_code',
            'bank',
            'account',
            'remark',
            'blacklist',
            'status',
            'syn_datetime',
        ]);
        $data['updated_by'] = '修改';

        $data['follow_up_nexttime'] = date('Y-m-d H:i:s', strtotime($data['follow_up_nexttime']));
        $data['contact_lasttime'] = date('Y-m-d H:i:s', strtotime($data['contact_lasttime']));
        $data['syn_datetime'] = date('Y-m-d H:i:s', strtotime($data['syn_datetime']));

        $ret = $customer->forceFill($data)->save();
        if ($ret) {

            $this->updateLoginAccount($customer, $request);

            return success_json($customer, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * 更新用户账号
     * @param Customer $customer
     * @param Request $request
     */
    public function updateLoginAccount(Customer $customer, Request $request)
    {
        if ($request->get('update_password')) {
            $customer->user()->update([
                'password' => bcrypt($request->get('password', default_password())),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return success_json($customer, '删除成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactConfig $contactConfig
     * @return \Illuminate\Http\Response
     */
    public function destroyList(Customer $customer, Request $request)
    {
        $ids = $request->get('ids', []);
        if (empty($ids)) {
            return error_json('请选择要删除的项次');
        }

        if (Customer::whereIn('id', $ids)->delete()) {
            return success_json([], '删除成功');
        }

        return error_json($customer, '删除失败');
    }
}
