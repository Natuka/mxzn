<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->only([
            'mobile',
            'display_name',
            'nickname',
        ]);

        $data['openid'] = str_random(32);
        $data['unionid'] = str_random(32);

        $user = new User();
        $user->forceFill($data)->save();

        return success_json($user);
    }
}
