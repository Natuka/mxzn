<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Requests\Admin\CustomerContact\CreateRequest;
use App\Http\Requests\Admin\CustomerContact\UpdateRequest;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CustomerContact $customercontact)
    {
        $customercontact = $this->search($request, $customercontact);
        return success_json($customercontact->with(['customer' => function( $query ){
            $query->select(['id','name']);
        }])->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, CustomerContact $customercontact)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $customercontact = $customercontact->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('name', 'like', '%'.$sch_value.'%')
                        ->orWhere('mobile', 'like', '%'.$sch_value.'%')
                        ->orWhere('job', 'like', '%'.$sch_value.'%');
                });
            }else{
                if ($sch_field == 'cust_id') {
                    $customercontact = $customercontact->whereHas('customer', function ($query) use ($sch_value) {
                        $query->where('name', 'like', '%'.$sch_value.'%');
                    });
                }else{
                    $customercontact = $customercontact->where($sch_field, 'like', '%'.$sch_value.'%');
                }
            }
        }


        return $customercontact;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, CustomerContact $customercontact)
    {
        $user = $request->user();
        $data = $request->only([
            'cust_id',
            'name',
            'sex',
            'birthday',
            'department',
            'post',
            'job',
            'mobile',
            'weixin',
            'qq',
            'email',
            'hobby',
            'address',
            'remark',
            'status',
        ]);
        //$request['source'] = $request->get('source', 3);
        $data['cust_id'] = (int)$data['cust_id'];
        $data['department'] = (int)$data['department'];
        $data['birthday'] = (new \Carbon\Carbon($data['birthday']))->toDateString(); //date('Y-m-d', strtotime($data['birthday']));
        $data['post'] = (int)$data['post'];
        $data['created_by'] = $user->userable_name;
        $data['updated_by'] = $user->userable_name;

        $ret = $customercontact->forceFill($data)->save();

        if ($ret) {
            $this->createLoginAccount($customercontact, $request);

            return success_json($customercontact, '');
        }

        return error_json('新增失败，请检查');
    }


    /**
     * 创建登录账号
     * @param Customer $customer
     * @param Request $request
     */
    public function createLoginAccount(CustomerContact $customercontact, Request $request)
    {
        $data = [
            'name' => $customercontact->mobile,
            'code' => $customercontact->cust_id,
            'userable_name' => $customercontact->name,
            'email' => $customercontact->email ?: 'S' . $customercontact->mobile . '@mxcs.com',
            'mobile' => (int)$customercontact->mobile,
            'qq' => '0',
            'wechat' => '',
            'valid' => 1,
            'password' => bcrypt($request->get('password', default_password())),
        ];

        if ($customercontact->user()->create($data)) {
            \Log::info('帐号创建成功');
        } else {
            \Log::info('帐号创建失败');
        }
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
     * @param  \App\Models\CustomerContact  $customercontact
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerContact $customercontact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerContact  $customercontact
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerContact $customercontact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerContact  $customercontact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, CustomerContact $customercontact)
    {
        $user = $request->user();
        $data = $request->only([
            'cust_id',
            'name',
            'sex',
            'birthday',
            'department',
            'post',
            'job',
            'mobile',
            'weixin',
            'qq',
            'email',
            'hobby',
            'address',
            'remark',
            'status',
        ]);
        $data['cust_id'] = (int)$data['cust_id'];
        $data['department'] = (int)$data['department'];
        $data['post'] = (int)$data['post'];
        $data['birthday'] = date('Y-m-d', strtotime($data['birthday']));
        $data['updated_by'] = $user->userable_name;
        $ret = $customercontact->forceFill($data)->save();

        if ($ret) {
            $this->updateLoginAccount($customercontact, $request);
//            $this->createLoginAccount($customercontact, $request);
            return success_json($customercontact, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * 更新用户账号
     * @param Customer $customer
     * @param Request $request
     */
    public function updateLoginAccount(CustomerContact $customercontact, Request $request)
    {
        $data_save = [
            'name' => $customercontact->mobile,
            'code' => $customercontact->cust_id,
            'userable_name' => $customercontact->name,
            'email' => $customercontact->email ?: 'S' . $customercontact->mobile . '@mxcs.com',
            'mobile' => (int)$customercontact->mobile,
        ];
        if ($request->get('update_password')) {
            $data_save['password'] = bcrypt($request->get('password', default_password()));
        }
        $customercontact->user()->update($data_save);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerContact  $customercontact
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerContact $customercontact)
    {
        $customercontact->delete();
        return success_json($customercontact, '删除成功');
    }
}
