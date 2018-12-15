<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeoController extends Controller
{
    /**
     * 获取经纬度
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request) {
        $lat = $request->get('lat', 0.0);
        $lng = $request->get('lng', 0.0);
        $res = file_get_contents('http://api.map.baidu.com/geocoder/v2/?location='. $lat .','. $lng .'&output=json&ak=NMYjhmxk9j88HCeXj0txBXfyGrDmq38j');
        $data = json_decode($res);
        return success_json($data);
    }
}
