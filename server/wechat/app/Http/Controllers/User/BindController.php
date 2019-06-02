<?php

namespace App\Http\Controllers\User;

use App\Models\AdminUser;
use App\Models\CustomerContact;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BindController extends Controller
{

    public function postBind(Request $request)
    {
        $mobile = e($request->get('mobile'));
        $user = auth()->user();
//        \Log::info([
//            'user7349558' => $user,
//            'mobile7349558' => $mobile,
//        ]);
        if ($user->mobile) {
            return error_json('您已经绑定手机号');
        }

        if (User::findByMobile($mobile)) {
            return error_json('该手机号已被绑定');
        }

        $contact = CustomerContact::findByMobile($mobile);
        if ($contact) {
            $user->userable_id = $contact->id;
            $user->userable_type = 'App\Models\CustomerContact';

            $user->mobile = $mobile;
            $user->save();
            return success_json('绑定成功,已提交审核');
        }

        $engineer = Staff::findByMobile($mobile);

        if ($engineer) {
            $user->userable_id = $engineer->id;
            $user->userable_type = 'App\Models\Staff';

            $user->mobile = $mobile;
            $user->save();
            return success_json('绑定成功,已提交审核');
        }

        $admin = AdminUser::findByMobile($mobile);

        if ($admin) {
            $user->userable_id = $admin->id;
            $user->userable_type = 'App\Models\AdminUser';
            $user->mobile = $mobile;
            $user->save();
            return success_json('绑定成功,已提交审核');
        }

        $user->mobile = $mobile;
        $user->save();
        return success_json('该手机号无效');
    }
}
