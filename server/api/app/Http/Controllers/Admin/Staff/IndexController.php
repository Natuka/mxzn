<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Requests\Admin\Staff\CreateRequest;
use App\Http\Requests\Admin\Staff\UpdateRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Staff $staff)
    {
        $staff = $this->search($request, $staff);
        return success_json($staff->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Staff $staff)
    {
        return $staff;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Staff $staff)
    {
        $data = $request->only([
            'org_id',
            'name',
            'sex',
            'birthday',
            'dep_id',
            'department',
            'post',
            'job',
            'graduated_school',
            'education',
            'skill_expertise',
            'hobby',
            'mobile',
            'weixin',
            'qq',
            'email',
            'status',
            'entry_date',
            'leave_date',
            'province_id',
            'city_id',
            'district_id',
            'address',
            'remark',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';
        $data['number'] = Staff::staffCode(date('Y-m-d')); //(系统自动编号)

        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            return success_json($staff, '');
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
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Staff $staff)
    {
        $data = $request->only([
            'org_id',
            'name',
            'sex',
            'birthday',
            'dep_id',
            'department',
            'post',
            'job',
            'graduated_school',
            'education',
            'skill_expertise',
            'hobby',
            'mobile',
            'weixin',
            'qq',
            'email',
            'status',
            'entry_date',
            'leave_date',
            'province_id',
            'city_id',
            'district_id',
            'address',
            'remark',
        ]);
        $data['updated_by'] = '修改';
        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            return success_json($staff, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return success_json($staff, '删除成功');
    }
}
