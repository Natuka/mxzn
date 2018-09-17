<?php

namespace App\Http\Controllers\Admin\Department;

use App\Http\Requests\Admin\Department\CreateRequest;
use App\Http\Requests\Admin\Department\UpdateRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Department $department)
    {
        $department = $this->search($request, $department);
        return success_json($department->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Department $department)
    {
        return $department;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Department $department)
    {
        $data = $request->only([
            'name',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $department->forceFill($data)->save();

        if ($ret) {
            return success_json($department, '');
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
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Department $department)
    {
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
        $ret = $department->forceFill($data)->save();

        if ($ret) {
            return success_json($department, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return success_json($department, '删除成功');
    }
}
