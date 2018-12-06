<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Requests\Admin\Service\CreateRequest;
use App\Http\Requests\Admin\Service\UpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Service $service)
    {
        $service = $this->search($request, $service);
        return success_json($service->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, Service $service)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $service = $service->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('content', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                $service = $service->where($sch_field, 'like', '%'.$sch_value.'%');
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $service = $service->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $service;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Service $service)
    {
        $data = $request->only([
            'name',
            'content',
            'workday',
            'area',
            'price',
            'unit',
            'is_land_traffic',
            'is_hotel',
            'effective_date',
            'expiration_date',
            'remark'
        ]);
        $data['number'] = Service::serviceCode(date('Y-m-d')); //(系统自动编号)

        $data['created_by'] = '新增';
        $data['area'] = intval($data['area']);
        $data['is_land_traffic'] = intval($data['is_land_traffic']);
        $data['is_hotel'] = intval($data['is_hotel']);
        $data['price'] = doubleval($data['price']);

        $data['effective_date'] = date('Y-m-d', strtotime($data['effective_date']));
        $data['expiration_date'] = date('Y-m-d', strtotime($data['expiration_date']));
        if (empty($data['effective_date']) || ($data['effective_date'] <= '1991-01-01')) $data['effective_date'] = NULL;
        if (empty($data['expiration_date']) || ($data['expiration_date'] <= '1991-01-01')) $data['expiration_date'] = NULL;

        $ret = $service->forceFill($data)->save();

        if ($ret) {
            return success_json($service, '');
        }

        return error_json('新增失败，请检查');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Service $service)
    {
        $data = $request->only([
            'name',
            'content',
            'workday',
            'area',
            'price',
            'unit',
            'is_land_traffic',
            'is_hotel',
            'effective_date',
            'expiration_date',
            'remark'
        ]);
        $data['updated_by'] = '修改';
        $data['area'] = intval($data['area']);
        $data['is_land_traffic'] = intval($data['is_land_traffic']);
        $data['is_hotel'] = intval($data['is_hotel']);
        $data['price'] = doubleval($data['price']);

        $data['effective_date'] = date('Y-m-d', strtotime($data['effective_date']));
        $data['expiration_date'] = date('Y-m-d', strtotime($data['expiration_date']));
        if (empty($data['effective_date']) || ($data['effective_date'] <= '1991-01-01')) $data['effective_date'] = NULL;
        if (empty($data['expiration_date']) || ($data['expiration_date'] <= '1991-01-01')) $data['expiration_date'] = NULL;

        $ret = $service->forceFill($data)->save();

        if ($ret) {
            return success_json($service, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return success_json($service, '删除成功');
    }
}
