<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Http\Requests\Admin\Agent\CreateRequest;
use App\Http\Requests\Admin\Agent\UpdateRequest;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Agent $agent)
    {
        $agent = $this->search($request, $agent);
        return success_json($agent->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Agent $agent)
    {
        return $agent;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Agent $agent)
    {
        $data = $request->only([
            'name',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $agent->forceFill($data)->save();

        if ($ret) {
            return success_json($agent, '');
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
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Agent $agent)
    {
        $data = $request->only([
            'name',
        ]);
        $data['updated_by'] = '修改';
        $ret = $agent->forceFill($data)->save();

        if ($ret) {
            return success_json($agent, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        $agent->delete();
        return success_json($agent, '删除成功');
    }
}
