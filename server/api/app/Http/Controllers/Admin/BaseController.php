<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @param Model $model
     * @param null $customPage
     * @return mixed
     */
    public function paginate(Model $model, $customPage = null)
    {
        return $model->paginate($customPage ? (int) $customPage : config('pageinfo.per_page'));
    }

}
