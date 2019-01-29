<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fan;

use App\Events\ExceptionEvent;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve(Request $request)
    {

        \DB::enableQueryLog();
        \DB::listen(function ($query) {
            \Log::info('sql', [$query->sql, $query->bindings, $query->time]);
        });

        try {
            $app = app('wechat.official_account');

            $app->server->push(function ($message) use ($app) {

                $wechatUser = null;
                $fan = Fan::findByOpenId($message['FromUserName']);
                if (!$fan) {
                    $wechatUser = $app->user->get($message['FromUserName']);
                    $fan = $this->create($wechatUser);
                }

                switch ($message['MsgType']) {
                    case 'event':
                        // 关注
                        if ('subscribe' === $message['Event']) {
                            // 扫描二维码进来
                            if (strpos($message['EventKey'], 'qrscene_') !== false) {
                                $screenId = (int)trim($message['EventKey'], 'qrscene_');
                                if ($screenId) {

                                }
                            }

                            if (!$wechatUser) {
                                $wechatUser = $app->user->get($message['FromUserName']);
                            }

                            $this->update($fan, $wechatUser);

                            return '欢迎关注明鑫智能';
                        }

                        // 取消关注
                        if ('unsubscribe' === $message['Event']) {
                            $fan->is_subscribe = 0;
                            $fan->unsubscribed_time = date('Y-m-d H:i:s', time());
                            $fan->save();
                        }

                        // 点击事件
                        if ('CLICK' === $message['Event']) {
                            // 暂不执行
                        }

                        break;
                    case 'text':
                        return '收到文字消息';
                        break;
                    case 'image':
                        return '收到图片消息';
                        break;
                    case 'voice':
                        return '收到语音消息';
                        break;
                    case 'video':
                        return '收到视频消息';
                        break;
                    case 'location':
                        return '收到坐标消息';
                        break;
                    case 'link':
                        return '收到链接消息';
                        break;
                    // ... 其它消息
                    default:
                        return '收到其它消息';
                        break;
                }

                return '';
            });

            return $app->server->serve();
        } catch (\Exception $e) {
            \Log::info([
                'log error'
            ]);

            \Log::info([
                'getMessage' => $e->getMessage(),
                'getTraceAsString' => $e->getTraceAsString(),
            ]);
            event(new ExceptionEvent($e));
            return '';
        }
    }

    /**
     * 更新用户信息
     *
     * @param [type] $fan
     * @param [type] $wechatUser
     * @return void
     */
    public function update($fan, $wechatUser = [])
    {
        if (isset($wechatUser['unionid']) && $fan->unionid != $wechatUser['unionid']) {
            $fan->unionid = $wechatUser['unionid'];
        }

        if (isset($wechatUser['sex']) && $fan->sex != $wechatUser['sex']) {
            $fan->sex = $wechatUser['sex'];
        }

        if (isset($wechatUser['language']) && $fan->language != $wechatUser['language']) {
            $fan->language = $wechatUser['language'];
        }

        if (isset($wechatUser['city']) && $fan->city != $wechatUser['city']) {
            $fan->city = $wechatUser['city'];
        }

        if (isset($wechatUser['province']) && $fan->province != $wechatUser['province']) {
            $fan->province = $wechatUser['province'];
        }

        if (isset($wechatUser['headimgurl']) &&  empty($fan->headimgurl) && $fan->headimgurl != $wechatUser['headimgurl']) {
            $fan->headimage = $wechatUser['headimgurl'];
        }

        $fan->save();
    }

    public function create($wechatUser)
    {
        $fan = new Fan();

        $fan->forceFill([
            'is_subscribe' => isset($wechatUser['subscribe']) ? $wechatUser['subscribe'] : 0,
//            'groupid' => isset($wechatUser['groupid']) ? $wechatUser['groupid'] : 0,
            'openid' => isset($wechatUser['openid']) ? $wechatUser['openid'] : '',
            'unionid' => isset($wechatUser['unionid']) ? $wechatUser['unionid'] : '',
            'nickname' => isset($wechatUser['nickname']) ? $wechatUser['nickname'] : '',
            'sex' => isset($wechatUser['sex']) ? $wechatUser['sex'] : '0',
            'language' => isset($wechatUser['language']) ? $wechatUser['language'] : '中文',
            'city' => isset($wechatUser['city']) ? $wechatUser['city'] : '',
            'province' => isset($wechatUser['province']) ? $wechatUser['province'] : '',
            'country' => isset($wechatUser['country']) ? $wechatUser['country'] : '',
            'headimage' => isset($wechatUser['headimgurl']) ? $wechatUser['headimgurl'] : '',
            'remark' => isset($wechatUser['remark']) ? $wechatUser['remark'] : '',
            'subscribed_time' => isset($wechatUser['remark']) ? date('Y-m-d H:i:s', $wechatUser['subscribe_time']) : null,
        ])->save();

        return $fan;
    }

    public function config(Request $request)
    {
//        TODO  本地端有误，cURL error 60: SSL certificate problem: unable to get local issuer certificate
        $app = app('wechat.official_account');
        $app->jssdk->setUrl($request->get('url', ''));

        $config = $app->jssdk->buildConfig(['onMenuShareQQ', 'onMenuShareWeibo', 'getLocation', 'checkJsApi'], false, false, false);
        return success_json($config);
    }

    /**
     * 获取用户头像
     * @param $path
     * @return mixed
     */
    public function fetchAvatar($path)
    {
        if (empty($path)) {
            return '/images/avatar/1.png';
        }

        $urlArr = parse_url($path);

        if (empty($urlArr)) {
            return '/images/avatar/1.png';
        }

        $url = (isset($urlArr['scheme']) && 'http' === $urlArr['scheme'] ? 'http' : 'https') . '://' . $urlArr['host'];

        $client = new Client;
        $ret = $client->request('GET', $path, ['timeout' => 2, 'header' => [
            'referer' => $url,
        ]]);

        $filepathArr = getfilepath('avatar');
        $filepath = $filepathArr['filepath'];
        file_put_contents($filepath, $ret->getBody());
        return $filepathArr['relativeFilename'];
    }
}
