<?php

namespace App\Http\Controllers\Admin\OutStaff;

use App\Http\Requests\Admin\OutStaff\CreateRequest;
use App\Http\Requests\Admin\OutStaff\UpdateRequest;
use App\Models\OutOutStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OutStaff $outstaff)
    {
        $outstaff = $this->search($request, $outstaff);
        return success_json($outstaff->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, OutStaff $outstaff)
    {
        return $outstaff;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, OutStaff $outstaff)
    {
        $data = $request->only([
            'name',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $outstaff->forceFill($data)->save();

        if ($ret) {
            return success_json($outstaff, '');
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
     * @param  \App\Models\OutStaff  $outstaff
     * @return \Illuminate\Http\Response
     */
    public function show(OutStaff $outstaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutStaff  $outstaff
     * @return \Illuminate\Http\Response
     */
    public function edit(OutStaff $outstaff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OutStaff  $outstaff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, OutStaff $outstaff)
    {
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
        $ret = $outstaff->forceFill($data)->save();

        if ($ret) {
            return success_json($outstaff, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutStaff  $outstaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutStaff $outstaff)
    {
        $outstaff->delete();
        return success_json($outstaff, '删除成功');
    }
}
