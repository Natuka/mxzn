<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Requests\Admin\Staff\CreateRequest;
use App\Http\Requests\Admin\Staff\UpdateRequest;
use App\Models\Staff;
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
    public function index(Request $request, Staff $staff)
    {
        $staff = $this->search($request, $staff);
        return success_json($staff->with(['dept' => function( $query ){
            $query->select(['id','name']);
        },'organization' => function( $query ){
            $query->select(['id','name']);
        }])->paginate(config('pageinfo.per_page')));
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
            'is_engineer',
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
        $data['is_engineer'] = (int)$data['is_engineer'];

        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';
        $data['number'] = Staff::staffCode(date('Y-m-d')); //(系统自动编号)

        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            $new_user_id = $this->createLoginAccount($staff, $request);

//            是否工程师，新增另一张表
            if ($data['is_engineer'] == 1 && $data['status'] == 1) {
                $this->createOrUpdateEngineer($staff, $new_user_id);
            }

            return success_json($staff, '');
        }

        return error_json('新增失败，请检查');
    }


    public function createLoginAccount(Staff $staff, Request $request)
    {
        $data = [
            'name' => $staff->number,
            'code' => $staff->number,
            'email' => $staff->email ?: 'S' . $staff->number . '@mxcs.com',
            'mobile' => (int)$staff->mobile,
            'qq' => '0',
            'wechat' => '',
            'valid' => 1,
            'password' => bcrypt($request->get('password', default_password())),
        ];

        if ($new_user = $staff->user()->create($data)) {
            \Log::info('用户创建成功');
            return $new_user->id;
        } else {
            \Log::info('用户创建失败');
            return -1;
        }
    }

    public function createOrUpdateEngineer(Staff $staff, $user_id)
    {
//        \Log::info('xxx-xx--xx'. $staff->user()->value('id'));
        if ($staff->is_engineer == 1 && $staff->status == 1) $status = 1;
        else $status = 0;
        $data = [
            'user_id' => (int)$staff->user()->value('id'),
            'org_id' => $staff->org_id,
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'status' => $status,
        ];
        $ret = Engineer::updateOrCreate(array('staff_id' => $staff->id), $data);

        if ($ret) {
            \Log::info('工程师创建成功');
        } else {
            \Log::info('工程师创建失败');
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
        $is_engineer_org = $staff->is_engineer; //原来的状态
        $data = $request->only([
            'org_id',
            'name',
            'sex',
            'birthday',
            'dep_id',
            'department',
            'post',
            'job',
            'is_engineer',
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
        $data['is_engineer'] = (int)$data['is_engineer'];

        $data['entry_date'] = format_date($data['entry_date']);
        $data['leave_date'] = format_date($data['leave_date']);
        $data['birthday'] = format_date($data['birthday']);
        if (empty($data['entry_date']) || ($data['entry_date'] <= '1901-01-01')) $data['entry_date'] = NULL;
        if (empty($data['leave_date']) || ($data['leave_date'] <= '1901-01-01')) $data['leave_date'] = NULL;
        if (empty($data['birthday']) || ($data['birthday'] <= '1901-01-01')) $data['birthday'] = NULL;

        $ret = $staff->forceFill($data)->save();

        if ($ret) {
            $this->updateLoginAccount($staff, $request);

            // 是否工程师，新增另一张表
            if ($data['is_engineer'] == 1 || ($data['is_engineer'] != $is_engineer_org) ) {
                $this->createOrUpdateEngineer($staff, 8);
            }

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
        $data_save = [
            'name' => $staff->number,
            'code' => $staff->number,
            'email' => $staff->email ?: 'S' . $staff->number . '@mxcs.com',
            'mobile' => (int)$staff->mobile,
        ];
        if ($request->get('update_password')) {
            $data_save['password'] = bcrypt($request->get('password', default_password()));
        }
        $staff->user()->update($data_save);
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
