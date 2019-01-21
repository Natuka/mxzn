<?php

namespace App\Traits;

use App\Models\Document;
use foo\bar;
use Illuminate\Http\Request;

use Illuminate\Http\UploadedFile;
use Image;

trait UploadTrait
{
    protected function __getExt(UploadedFile $file)
    {
        $ext = strtolower($file->getClientOriginalExtension());
        if ($ext) {
            return $ext;
        }
        return strtolower($file->guessExtension());
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');

        if (!$file) {
            return error_json('请选择上传文件');
        }

        $ext = $this->__getExt($file);

        if (!in_array($ext, ['png', 'jpg', 'gif', 'jpeg', 'pdf', 'doc', 'csv', 'xls', 'xlsx', 'zip', 'rar', 'txt'])) {
            return error_json('文件上传格式错误['.$ext.']，支持类型 pdf,doc,csv,xls,xlsx,zip,rar');
        }

        $relativePath = date('Y/m');

        $appPath = storage_path('app/public/' . $relativePath);

        is_dir($appPath) or mkdir($appPath, 0755, true);

        $appId = (int)$request->get('id');

        $document = new Document();

        $params = [
            'id' => $appId,
            'time' => microtime(true),
            'filename' => '',
            'token' => $request->header('Authorization'),
            'source_name' => $file->getClientOriginalName()
        ];

        $fileName = 'doc_' . microtime(true) . '.' . $ext;

        $saveName = $file->move($appPath, $fileName);

        $data = [
            // 根据source来生成规则
            'source' => $request->get('source', 1), // 故障附件 1, 处理措施结果附件 2，故障原因附件 3, 产品图片 4, 二维码图片 5，其他 6
            'name' => $fileName,
            'path' => '/' . $relativePath . '/' . $fileName,
            'type' => $request->get('type', 1),
            'ext' => $ext,
            'size' => $file->getClientSize(),
            'up_from' => 1,
            'source_name' => $file->getClientOriginalName()
        ];

        $document->forceFill($data)->save();

        $params['filename'] = $fileName;
        $params['id'] = $document->id;
        return success_json([
            'url' => '/docs/?' . http_build_query($params),
            'id' => $document->id,
            'name' => $fileName,
            'saveName' => $saveName,
            'ext' => $ext,
            'size' => $file->getClientSize(),
            'up_from' => 1,
            'source_name' => $file->getClientOriginalName()
        ]);
    }

    /**
     * 保存logo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return error_json('请选择上传文件');
        }

        $ext = $this->__getExt($file);

        if (!in_array($ext, ['png', 'jpg', 'gif', 'jpeg'])) {
            $this->uploadFile($request);
            exit;
//            return error_json('文件上传格式错误['.$ext.']，支持类型 png,jpg,gif,jpeg');
        }

        $relativePath = date('Y/m');

        $appPath = storage_path('app/public/' . $relativePath);

        is_dir($appPath) or mkdir($appPath, 0755, true);

        $appId = (int)$request->get('id');

        $document = new Document();

        $params = [
            'id' => $appId,
            'time' => microtime(true),
            'filename' => '',
            'token' => $request->header('Authorization'),
            'source_name' => $file->getClientOriginalName()
        ];

        $img = Image::make($file);

        $fileName = 'img_' . microtime(true) . '.' . $ext;

        $img->save($appPath . '/' . $fileName);

        $data = [
            // 根据source来生成规则
            'source' => $request->get('source', 1), // 故障附件 1, 处理措施结果附件 2，故障原因附件 3, 产品图片 4, 二维码图片 5，其他 6
            'name' => $fileName,
            'path' => '/' . $relativePath . '/' . $fileName,
            'type' => $request->get('type', 1),
            'ext' => $ext,
            'size' => $file->getSize(),
            'up_from' => 1,
            'source_name' => $file->getClientOriginalName()
        ];

        $document->forceFill($data)->save();

        $params['filename'] = $fileName;
        $params['id'] = $document->id;

        return success_json([
            'url' => '/image/?' . http_build_query($params),
            'id' => $document->id,
            'name' => $fileName,
            'ext' => $ext,
            'size' => $file->getSize(),
            'up_from' => 1,
            'source_name' => $file->getClientOriginalName()
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

    // 显示文件
    public function getFile(Request $request)
    {
        $id = $request->get('id', 0);
        $info = Document::find($id);
        return success_json($info);
    }
}
