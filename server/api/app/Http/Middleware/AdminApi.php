<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Staff;
use App\Models\SupplierAccount;
use App\Models\LoginRecord;

class AdminApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $name = \Route::currentRouteName();
        \Log::info(['name' => $name, 'can' => $user->can($name), 'action' => \Route::currentRouteAction()]);
        return $next($request);
    }

    public function terminate($request, $response)
    {
//        $user = auth()->user();
//        sys_log([
//            'content' => 'terminate in'.($user ? $user->id : 0),
//        ], 'terminate');
//
//        if (!$user) {
//            return;
//        }
//        //为员工时，变更最后登录时间
//        if ('App\Models\Staff' == $user->userable_type && 0 < $user->userable_id) {
//            $staff = Staff::find($user->userable_id);
//            \Log::info(['name' => $staff]);
//            //添加登入日志
//            if ($staff) {
//                $staff_name = $staff->name;
//            } else {
//                $staff_name = $user->name;
//            }
//            LoginRecord::log('online_1', $user->id, $user->name, $staff_name);
//        } elseif ('App\Models\SupplierAccount' == $user->userable_type && 0 < $user->userable_id) {
//            $supplier = SupplierAccount::find($user->userable_id);
//            //添加登入日志
//            if ($supplier) {
//                $supplier_name = $supplier->name;
//            } else {
//                $supplier_name = $user->name;
//            }
//            LoginRecord::log('online_2', $user->id, $user->name, $supplier_name);
//        } else {
//            LoginRecord::log('online_3', $user->id, $user->name);
//        }
    }
}
