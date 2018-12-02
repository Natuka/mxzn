<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function info(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            return success_json($user, '222');
        }

        return error_json('未登录', 403);
    }
}
