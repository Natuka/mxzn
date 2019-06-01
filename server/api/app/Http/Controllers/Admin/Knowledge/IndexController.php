<?php

namespace App\Http\Controllers\Admin\Knowledge;

use App\Http\Requests\Admin\Knowledge\CreateRequest;
use App\Http\Requests\Admin\Knowledge\UpdateRequest;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, KnowledgeBase $knowledge)
    {
        $knowledge = $this->search($request, $knowledge);
        return success_json($knowledge->paginate( config('pageinfo.per_page') ));
    }

    public function search(Request $request, KnowledgeBase $knowledge)
    {
        $sch_field = $request->get('schField', ''); //查询字段或模糊查询
        $sch_value = $request->get('schValue', ''); //查询字段或模糊查询
        //$sch_field = 'fuzzy_query';
        if ($sch_value && $sch_field) {
            if ($sch_field == 'fuzzy_query') {
                $knowledge = $knowledge->where(function($query) use($sch_field, $sch_value)
                {
                    $query->where('subject_name', 'like', '%'.$sch_value.'%')
                        ->orWhere('label', 'like', '%'.$sch_value.'%')
                        ->orWhere('text', 'like', '%'.$sch_value.'%')
                        ->orWhere('remark', 'like', '%'.$sch_value.'%');
                });
            }else{
                $knowledge = $knowledge->where($sch_field, 'like', '%'.$sch_value.'%');
            }
        }
        $orderField = $request->get('orderField', 0); // 排序栏位
        $orderBy = $request->get('orderBy', 0); // 排序顺序
        $orderFieldArray = array('0' => 'subject_name', '1' => 'type');
        $orderByArray = array('0' => 'ASC', '1' => 'DESC',);
        if (!empty($orderFieldArray[$orderField]) && !empty($orderByArray[$orderBy])) {
            $knowledge = $knowledge->orderBy($orderFieldArray[$orderField], $orderByArray[$orderBy]);
        }
        return $knowledge;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request, KnowledgeBase $knowledge)
    {
        $user = $request->user();
        $data = $request->only([
            'subject_name',
            'type',
            'type1',
            'label',
            'downloads',
            'text',
            'attach_file',
            'remark',
        ]);
        $data['created_by'] = $user->userable_name;

        $data['type'] = intval($data['type']);
        $data['type1'] = intval($data['type1']);
        $data['downloads'] = intval($data['downloads']);

        //dd($data);
        $ret = $knowledge->forceFill($data)->save();

        if ($ret) {
            return success_json($knowledge, '');
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
     * @param  \App\Models\KnowledgeBase  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeBase $knowledge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeBase  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeBase $knowledge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeBase  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, KnowledgeBase $knowledge)
    {
        $user = $request->user();
//        \Log::info([
//            'XXXX789651' => $user
//        ]);
        $data = $request->only([
            'subject_name',
            'type',
            'type1',
            'label',
            'downloads',
            'text',
            'attach_file',
            'remark',
        ]);
        $data['updated_by'] = $user->userable_name;

        $data['type'] = intval($data['type']);
        $data['type1'] = intval($data['type1']);
        $data['downloads'] = intval($data['downloads']);

        $ret = $knowledge->forceFill($data)->save();

        if ($ret) {
            return success_json($knowledge, '');
        }

        return error_json('修改失败，请检查');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeBase  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeBase $knowledge)
    {
        $knowledge->delete();
        return success_json($knowledge, '删除成功');
    }
}
