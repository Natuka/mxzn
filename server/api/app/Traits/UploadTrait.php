<?php

namespace App\Traits;

use App\Models\Document;
use Illuminate\Http\Request;

use Image;

trait UploadTrait
{
    /**
     * 保存logo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');

        $relativePath = date('Y/m');

        $appPath = storage_path('app/public/' . $relativePath);

        is_dir($appPath) or mkdir($appPath, 0755, true);

        $appId = (int)$request->get('id');

        $document = new Document();

        $params = [
            'id' => $appId,
            'time' => microtime(true),
            'filename' => '',
            'token' => $request->header('Authorization')
        ];

        $img = Image::make($file);

        $fileName = 'tmp_' . microtime(true) . '.png';

        $img->save($appPath . '/' . $fileName);

        $data = [
            // 根据source来生成规则
            'source' => $request->get('source', 1), // 故障附件 1, 处理措施结果附件 2，故障原因附件 3, 产品图片 4, 二维码图片 5，其他 6
            'name' => $fileName,
            'path' => '/' . $relativePath . '/' . $fileName,
            'type' => $request->get('type', 1),
            'ext' => $file->getExtension(),
            'size' => $file->getSize(),
        ];

        $document->forceFill($data)->save();

        $params['filename'] = $fileName;

        return success_json([
            'url' => '/image/?' . http_build_query($params),
            'id' => $document->id,
            'name' => $fileName
        ]);
    }

    // 显示图片
    public function getImage(Request $request)
    {
        $id = $request->get('id', 0);
        $info = Document::find($id);
        if ($info) {
            return Image::make(storage_path('app/public' . $info->path))->response('jpg');
        }
    }
}
