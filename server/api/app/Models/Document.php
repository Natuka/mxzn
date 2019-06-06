<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $table = 'base_documents';

    public static function getDocumentNames($ids)
    {
        $listNames = '';
        $idsArray = explode(',', $ids);
        if (0 < count($idsArray)) {
            $data = static::whereIN('id', $idsArray)->orderBy('id', 'asc')->select('source_name')->get();
            foreach ($data as $dataRow) {
                if (!empty($listNames)) $listNames .= "\r";
                $listNames .= $dataRow->source_name;
            }
        }
        return $listNames;
    }

}
