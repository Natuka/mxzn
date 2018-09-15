<?php

namespace App\Http\Controllers\Admin\Customer;

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
        $ret = $customer->forceFill($request->only([
            'name',
        ]))->save();

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
        $ret = $customer->forceFill($request->only([
            'name',
        ]))->save();

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
