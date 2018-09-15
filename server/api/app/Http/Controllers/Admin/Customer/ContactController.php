<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Models\CustomerContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CustomerContact $customerContact)
    {
        $customerContact = $this->search($request, $customerContact);
        return success_json($customerContact->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, CustomerContact $customerContact)
    {
        return $customerContact;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, CustomerContact $customerContact)
    {
        $ret = $customerContact->forceFill($request->only([
            'name',
        ]))->save();

        if ($ret) {
            return success_json($customerContact, '');
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
     * @param  \App\Models\CustomerContact  $customerContact
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerContact $customerContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerContact  $customerContact
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerContact $customerContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerContact  $customerContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CustomerContact $customerContact)
    {
        $ret = $customerContact->forceFill($request->only([
            'name',
        ]))->save();

        if ($ret) {
            return success_json($customerContact, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerContact  $customerContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerContact $customerContact)
    {
        //
    }
}
