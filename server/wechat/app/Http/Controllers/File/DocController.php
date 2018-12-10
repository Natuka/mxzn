<?php

namespace App\Http\Controllers\File;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\UploadTrait;

class DocController extends Controller
{
    use UploadTrait;


    public function store(Request $request)
    {
        return $this->uploadFile($request);
    }

    public function get(Request $request)
    {
        return $this->getFile($request);
    }

    /**
     * 获取列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $docIds = (array)$request->get('ids', []);
        if (!$docIds) {
            return error_json('');
        }
        $data = Document::findMany($docIds, ['id', 'source', 'source_name', 'type', 'size', 'ext', 'name', 'path']);
        return success_json($data);
    }
}
