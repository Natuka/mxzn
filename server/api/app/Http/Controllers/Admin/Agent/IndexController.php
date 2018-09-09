<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Http\Requests\Admin\Agent\CreateRequest;
use App\Http\Requests\Admin\Agent\UpdateRequest;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //

    public function index(Request $request, Agent, $agent)
    {
        $agent = $this->search($request, $agent);
       return success_json($agent->paginate(10));
    }

    public function search(Request $request, Agent $agent)
    {
        return $agent;
    }

    /**
     * 创建
     * @param CreateRequest $request
     * @param Agent $agent
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request, Agent $agent)
    {
        $ret = $agent->forceFill($request->only([
            'name',
        ]))->save();

        if ($ret) {
            return success_json($agent, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * 修改
     * @param CreateRequest $request
     * @param Agent $agent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Agent $agent)
    {
        $ret = $agent->forceFill($request->only([
            'name',
        ]))->save();

        if ($ret) {
            return success_json($agent, '');
        }

        return error_json('新增失败，请检查');
    }
}
