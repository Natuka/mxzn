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
        $data['created_by'] = '新增';
        $data['updated_by'] = '新增';

        $ret = $customercontact->forceFill($data)->save();

        if ($ret) {
            return success_json($customercontact, '');
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
        $data['updated_by'] = '修改';
        $ret = $customercontact->forceFill($data)->save();

        if ($ret) {
            return success_json($customercontact, '');
        }

        return error_json('修改失败，请检查');
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
