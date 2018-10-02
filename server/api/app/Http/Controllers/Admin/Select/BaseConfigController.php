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
    public function job()
    {
        return $this->listBy(__METHOD__);
    }

    /**
     * 职位
     * @return \Illuminate\Http\JsonResponse
     */
    public function post()
    {
        return $this->listBy(__METHOD__);
    }

    /**
     * 学历
     * @return \Illuminate\Http\JsonResponse
     */
    public function education()
    {
        return $this->listBy(__METHOD__);
    }

    /**
     * 列表页
     * @param $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function listBy($name)
    {
        if (strpos($name, '::')) {
            $name = substr($name, strpos($name,'::') + 2);
        }

        return success_json(BaseConfig::childrenByName($name));
    }

}
