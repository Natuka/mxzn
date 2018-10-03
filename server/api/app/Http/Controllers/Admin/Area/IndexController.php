<?php

namespace App\Http\Controllers\Admin\Area;

use App\Http\Controllers\Controller;
use App\Models\Area;

class IndexController extends Controller
{

    public function provinces()
    {
        return success_json(Area::where('parent_id', 0)->orderBy('id', 'asc')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area, $id, $level = 1)
    {
        return success_json(Area::where('parent_id', $id)->where('level', $level)->orderBy('id', 'asc')->get());
    }

    public function cities(Area $area)
    {
        return success_json($area->where('level', 2)->orderBy('id', 'asc')->get());
    }

}
