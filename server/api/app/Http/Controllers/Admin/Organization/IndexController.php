<?php

namespace App\Http\Controllers\Admin\Organization;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Requests\Admin\Organization\CreateRequest;
use App\Http\Requests\Admin\Organization\UpdateRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Organization $organization)
    {
        $organization = $this->search($request, $organization);
        return success_json($this->paginate($organization));
    }

    public function search(Request $request, Organization $organization)
    {
        if ($name = $request->get('name')) {
            $organization = $organization->where('name', 'like', '%' . $name . '%');
        }
        return $organization;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, Organization $organization)
    {
        $data = $request->only([
            'number',
            'name',
            'name_short',
            'type',
        ]);

        $data['created_by'] = 'system';
        $data['updated_by'] = 'system';

        $organization = $organization->forceFill($data);
        if ($organization->save()) {
            return success_json($organization, '新增成功');
        }

        return error_json('新增失败');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Organization $organization)
    {
        $data = $request->only([
            'number',
            'name',
            'name_short',
            'type',
        ]);

        $data['created_by'] = 'system';
        $data['updated_by'] = 'system';

        $organization = $organization->forceFill($data);
        if ($organization->save()) {
            return success_json($organization, '修改成功');
        }

        return error_json('修改失败');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
