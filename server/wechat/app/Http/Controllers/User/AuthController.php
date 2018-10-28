<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\LoginRequest;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $mobile = $request->get('mobile', '');
        $code = $request->get('code', '');

        $user = User::findByMobile($mobile);

        if ($user) {
            Auth::login($user);
            return success_json($user);
        }

        return error_json('登录失败', 400);
    }

    public function info(Request $request)
    {
        $user = auth()->user();

        return success_json($user);
    }
}
