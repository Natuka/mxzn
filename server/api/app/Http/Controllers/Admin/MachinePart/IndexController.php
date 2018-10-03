<?php

namespace App\Http\Controllers\Admin\MachinePart;

use App\Http\Requests\Admin\MachinePart\CreateRequest;
use App\Http\Requests\Admin\MachinePart\UpdateRequest;
use App\Models\MachinePart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MachinePart $machinepart)
    {
        $machinepart = $this->search($request, $machinepart);
        return success_json($machinepart->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, MachinePart $machinepart)
    {
        return $machinepart;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, MachinePart $machinepart)
    {
        $data = $request->only([
            'name',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $machinepart->forceFill($data)->save();

        if ($ret) {
            return success_json($machinepart, '');
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
     * @param  \App\Models\MachinePart  $machinepart
     * @return \Illuminate\Http\Response
     */
    public function show(MachinePart $machinepart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MachinePart  $machinepart
     * @return \Illuminate\Http\Response
     */
    public function edit(MachinePart $machinepart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MachinePart  $machinepart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, MachinePart $machinepart)
    {
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
        $ret = $machinepart->forceFill($data)->save();

        if ($ret) {
            return success_json($machinepart, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MachinePart  $machinepart
     * @return \Illuminate\Http\Response
     */
    public function destroy(MachinePart $machinepart)
    {
        $machinepart->delete();
        return success_json($machinepart, '删除成功');
    }
}
