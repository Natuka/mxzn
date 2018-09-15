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
        return success_json($customer->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Customer $customer)
    {
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

        $ret = $customer->forceFill($data)->save();

        if ($ret) {
            return success_json($customer, '');
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
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
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
        $ret = $customer->forceFill()->save();

        if ($ret) {
            return success_json($customer, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
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
     * @param  \App\Models\ContactConfig  $contactConfig
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
