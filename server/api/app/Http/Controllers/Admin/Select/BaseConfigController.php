<?php

namespace App\Http\Controllers\Admin\Select;

use App\Http\Controllers\Admin\BaseController;
use App\Models\BaseConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseConfigController extends BaseController
{
    /**
     * 职务
     * @return \Illuminate\Http\JsonResponse
     */
    public function job(Request $request)
    {
        return $this->listBy(__METHOD__, $request);
    }

    /**
     * 职位
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(Request $request)
    {
        return $this->listBy(__METHOD__, $request);
    }

    /**
     * 学历
     * @return \Illuminate\Http\JsonResponse
     */
    public function education(Request $request)
    {
        return $this->listBy(__METHOD__, $request);
    }

    /**
     * 列表页
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function listBy($name, Request $request)
    {
        if (strpos($name, '::')) {
            $name = substr($name, strpos($name,'::') + 2);
        }

        if ($request->has('with-page')) {
            return success_json(BaseConfig::childrenByNameWithPage($name));
        }

        return success_json(BaseConfig::childrenByName($name));
    }

}
