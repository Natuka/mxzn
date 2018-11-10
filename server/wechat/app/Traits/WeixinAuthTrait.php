<?php

namespace App\Traits;

use App\Models\Fan;

trait WeixinAuthTrait {
  // 微信登录授权
  public function createOr()
  {
    $user = session('wechat.oauth_user.default');

    $fan = Fan::findByOpenId($user->id);
    if (!$fan) {
      $fan = new Fan();
      $fan->forceFill([
        'openid' => $user->id,
        'nickname' => $user->name,
        'display_name' => $user->name,
        'headimage' => $user->avatar,
        'userable_id' => 0,
        'userable_type' => '',
      ])->save();
    }

     Auth::login($fan);
     return $fan;
  }
}