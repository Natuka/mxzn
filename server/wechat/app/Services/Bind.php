<?php
/**
 * Created by PhpStorm.
 * User: natuka
 * Date: 2018-12-10
 * Time: 06:43
 */

namespace App\Services;


class Bind
{
    public static function run()
    {
        $user = auth()->user();
        if ($user->user_type) {
            return false;
        }

        $mobile = $user->mobile;

        $contact = CustomerContact::findByMobile($mobile);
        if ($contact) {
            $user->userable_id = $contact->id;
            $user->userable_type = 'App\Models\CustomerContact';

            $user->mobile = $mobile;
            return true;
        }

        $engineer = Staff::findByMobile($mobile);

        if ($engineer) {
            $user->userable_id = $engineer->id;
            $user->userable_type = 'App\Models\Staff';

            $user->mobile = $mobile;
            return true;
        }

        $admin = AdminUser::findByMobile($mobile);

        if ($admin) {
            $user->userable_id = $admin->id;
            $user->userable_type = 'App\Models\AdminUser';
            $user->mobile = $mobile;
            return true;
        }
    }
}
