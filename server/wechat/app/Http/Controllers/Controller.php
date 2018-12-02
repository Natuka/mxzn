<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user()
    {
        return auth()->user();
    }

    public function staff()
    {
        return $this->user()->staff();
    }

    public function customer()
    {
        $user = $this->user();
        if (!$user || !$user->isCustomer) {
            return null;
        }

        return $user->info && $user->info->customer ? $user->info->customer : null;
    }

    /**
     * 是否绑定手机号
     * @return bool
     */
    public function isBind()
    {
        $user = $this->user();
        if (!$user) {
            return false;
        }

        if (!$user->mobile) {
            return true;
        }

        return true;
    }
}
