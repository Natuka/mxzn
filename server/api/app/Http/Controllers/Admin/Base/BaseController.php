<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\BaseConfig;

class BaseController extends Controller
{
    protected $name = '';

    public function getList(Request $request)
    {
        return $this->listBy($this->name, $request);
    }

    /**
     * 列表页
     * @param $name
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listBy($name, Request $request)
    {
        if (strpos($name, '::')) {
            $name = substr($name, strpos($name,'::') + 2);
        }

        return success_json(BaseConfig::childrenByNameWithPage($name));
    }

    /**
     * 获取父ID
     * @return int|mixed
     */
    public function getParentId()
    {
        $data = config('base_config.' . $this->name, []);
        if (empty($data)) {
            return 0;
        }

        return $data['id'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getList($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BaseConfig $baseConfig)
    {
        //
        $data = $request->only([
            'name',
            'number',
            'sort',
            'status',
            'remark',
        ]);

        $data['parent_id'] = $this->getParentId();
        if (!$data['parent_id']) {
            return error_json('所属类型错误');
        }

        $ret = $baseConfig->forceFill($data)->save();

        if ($ret) {
            return success_json('保存成功');
        }
        return error_json('保存失败');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BaseConfig  $baseConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseConfig $baseConfig)
    {
        //
        $data = $request->only([
            'name',
            'number',
            'sort',
            'status',
            'remark',
        ]);

        if ($baseConfig->parent_id != $this->getParentId()) {
            return error_json('所属类型错误');
        }

        $data['parent_id'] = $this->getParentId();

        $ret = $baseConfig->forceFill($data)->save();

        if ($ret) {
            return success_json('保存成功');
        }
        return error_json('保存失败');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BaseConfig  $baseConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaseConfig $baseConfig)
    {
        //
        if (!$baseConfig || $baseConfig->id <= 0) {
            return error_json('数据不存在，请选择其他数据');
        }

        if ($baseConfig->delete()) {
            return error_json('删除成功');
        }

        return error_json('删除失败');
    }
}
