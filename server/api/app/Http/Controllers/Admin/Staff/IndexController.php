<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Requests\Admin\Staff\CreateRequest;
use App\Http\Requests\Admin\Staff\UpdateRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Staff $staff)
    {
        $staff = $this->search($request, $staff);
        return success_json($staff->paginate(config('pageinfo.per_page')));
    }

    public function search(Request $request, Staff $staff)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $staff = $staff->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('mobile', 'like', '%'.$sch_value.'%')
                        ->orWhere('number', 'like', '%'.$sch_value.'%');
                });
            }else{
                $staff = $staff->where($sch_field, 'like', '%'.$sch_value.'%');
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'number', '1' => 'name');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $staff = $staff->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $staff;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, Staff $staff)
    {
        $data = $request->only([
            'org_id',
            'name',
            'sex',
            'birthday',
            'dep_id',
            'department',
            'post',
            'job',
            'graduated_school',
            'education',
            'skill_expertise',
            'hobby',
            'mobile',
            'weixin',
            'qq',
            'email',
            'status',
            'entry_date',
            'leave_date',
            'province_id',
            'city_id',
            'district_id',
            'address',
            'remark',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['province_id'] = (int)$data['province_id'];
        $data['city_id'] = (int)$data['city_id'];
        $data['district_id'] = (int)$data['district_id'];
        $data['dep_id'] = (int)$data['dep_id'];

        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';
        $data['number'] = Staff::staffCode(date('Y-m-d')); //(系统自动编号)

        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            $this->createLoginAccount($staff, $request);
            return success_json($staff, '');
        }

        return error_json('新增失败，请检查');
    }


    public function createLoginAccount(Staff $staff, Request $request)
    {
        $data = [
            'name' => $staff->name,
            'code' => $staff->number,
            'email' => $staff->email ?: 'S' . $staff->number . '@mxcs.com',
            'number' => $staff->number,
            'mobile' => (int)$staff->mobile,
            'qq' => '0',
            'wechat' => '',
            'valid' => 1,
            'password' => bcrypt($request->get('password', default_password())),
        ];

        if ($staff->user()->create($data)) {
            \Log::info('用户创建成功');
        } else {
            \Log::info('用户创建失败');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Staff $staff)
    {
        $data = $request->only([
            'org_id',
            'name',
            'sex',
            'birthday',
            'dep_id',
            'department',
            'post',
            'job',
            'graduated_school',
            'education',
            'skill_expertise',
            'hobby',
            'mobile',
            'weixin',
            'qq',
            'email',
            'status',
            'entry_date',
            'leave_date',
            'province_id',
            'city_id',
            'district_id',
            'address',
            'remark',
        ]);
        $data['updated_by'] = '修改';

        $data['province_id'] = (int)$data['province_id'];
        $data['city_id'] = (int)$data['city_id'];
        $data['district_id'] = (int)$data['district_id'];
        $data['dep_id'] = (int)$data['dep_id'];

        $data['entry_date'] = format_date($data['entry_date']);
        $data['leave_date'] = format_date($data['leave_date']);
        $data['birthday'] = format_date($data['birthday']);

        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            $this->updateLoginAccount($staff, $request);
            return success_json($staff, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * 更新用户账号
     * @param Staff $staff
     * @param Request $request
     */
    public function updateLoginAccount(Staff $staff, Request $request)
    {
        if ($request->get('update_password')) {
            $staff->user()->update([
                'password' => bcrypt($request->get('password', default_password())),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return success_json($staff, '删除成功');
    }
}
