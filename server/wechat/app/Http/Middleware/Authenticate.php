<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\Bind;
use Closure;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        $user = session('wechat.oauth_user.default');

        // 执行微信登录
        if ($user && !auth()->user()) {
            $this->checkOrCreate();
            return redirect('/?#' . $request->getRequestUri());
        }

        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        return route('login');
    }

    protected function checkOrCreate()
    {
        $user = session('wechat.oauth_user.default');
        $wechatUser = \EasyWeChat::officialAccount()->user->get($user->getId());
//        \Log::info([
//            'wechatUser769558' => $wechatUser
//        ]);
/*      只取得如下资料
 *         array (
            'subscribe' => 0,
            'openid' => 'oAKlrwPt0-nIHMkmEbZVDvZtCdLw',
            'tagid_list' =>
                array (
                ),
        ),*/
        $fan = User::findByOpenid($wechatUser['openid']);
        if (!$fan) {
            if (!isset($wechatUser['nickname']) || empty($wechatUser['nickname'])) {
                $wechatUser['nickname'] = $wechatUser['openid'];
            }
            if (!isset($wechatUser['sex']) || empty($wechatUser['sex'])) {
                $wechatUser['sex'] = 2; // 未知
            }
            if (!isset($wechatUser['language']) || empty($wechatUser['language'])) {
                $wechatUser['language'] = 'zh_CN'; // 未知
            }
            if (!isset($wechatUser['city']) || empty($wechatUser['city'])) {
                $wechatUser['city'] = ''; // 未知
            }
            if (!isset($wechatUser['province']) || empty($wechatUser['province'])) {
                $wechatUser['province'] = ''; // 未知
            }
            if (!isset($wechatUser['country']) || empty($wechatUser['country'])) {
                $wechatUser['country'] = ''; // 未知
            }
            $fan = new User();
            $fan->forceFill([
                'openid' => $wechatUser['openid'],
                'unionid' => $wechatUser['openid'],
                'nickname' => $wechatUser['nickname'],
                'sex' => $wechatUser['sex'],
                'language' => $wechatUser['language'],
                'city' => $wechatUser['city'],
                'province' => $wechatUser['province'],
                'country' => $wechatUser['country'],
//                'headimgurl' => $wechatUser['headimgurl'],
            ]);

            $fan->save();
        }

        if ($fan) {
            \Auth::login($fan);
            Bind::run();
        }
    }

}
