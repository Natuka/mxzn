<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderRepair extends Model
{
    //

    protected $appends = ['cause_docs', 'step_docs'];

    public function getCauseDocsAttribute()
    {
        $ids = $this->attributes['cause_doc_ids'];
        if (empty($ids)) {
            return [];
        }

        return Document::find(explode(',', $ids));
    }

    public function getStepDocsAttribute()
    {
        $ids = $this->attributes['step_doc_ids'];
        if (empty($ids)) {
            return [];
        }

        return Document::find(explode(',', $ids));
    }
}
