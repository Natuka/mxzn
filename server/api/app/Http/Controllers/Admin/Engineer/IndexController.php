<?php

namespace App\Http\Controllers\Admin\Engineer;

use App\Http\Requests\Admin\Engineer\CreateRequest;
use App\Http\Requests\Admin\Engineer\UpdateRequest;
use App\Models\Engineer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Engineer $engineer)
    {
        $engineer = $this->search($request, $engineer);
        return success_json($engineer->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Engineer $engineer)
    {
        return $engineer;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Engineer $engineer)
    {
        $data = $request->only([
            'name',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $engineer->forceFill($data)->save();

        if ($ret) {
            return success_json($engineer, '');
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
     * @param  \App\Models\Engineer  $engineer
     * @return \Illuminate\Http\Response
     */
    public function show(Engineer $engineer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Engineer  $engineer
     * @return \Illuminate\Http\Response
     */
    public function edit(Engineer $engineer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Engineer  $engineer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Engineer $engineer)
    {
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
        $ret = $engineer->forceFill($data)->save();

        if ($ret) {
            return success_json($engineer, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engineer  $engineer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engineer $engineer)
    {
        $engineer->delete();
        return success_json($engineer, '删除成功');
    }
}
