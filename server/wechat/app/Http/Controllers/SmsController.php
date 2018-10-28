<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendSmsRequest;

class SmsController extends Controller
{
    //
    public function post(SendSmsRequest $request)
    {
        $mobile = $request->get('mobile', '');
        $code = $request->get('code', '');

        return success_json([
           'mobile' => $mobile,
            'code' => $code,
        ]);
    }
}
