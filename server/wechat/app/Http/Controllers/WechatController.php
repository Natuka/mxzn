<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fan;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        try {
            $app = app('wechat.official_account');
            $app->server->push(function($message) use ($app){
                $fan = Fan::findByOpenId($message->FromUserName);
                if (!$weixinUser) {
                    $wechatUser = $app->user->get($message->FromUserName);
                    $fan = $this->create($wechatUser);
                }

                switch ($message->MsgType) {
                    case 'event':
                        // 关注
                        if ('subscribe' === $message->Event) {
                            // 扫描二维码进来
                            if (strpos($message->EventKey, 'qrscene_') !== false) {
                                $screenId = (int) trim($message->EventKey, 'qrscene_');
                                if ($screenId) {
                            
                                }
                            }

                            $this->update($fan, $weixinUser);
                     
                            return ''; 
                        }

                        // 取消关注
                        if ('unsubscribe' === $message->Event) {
                            $fan->is_subscribe = 0;
                            $fan->unsubscribed_time = date('Y-m-d H:i:s', time());
                            $fan->save();
                        }

                        // 点击事件
                        if ('CLICK' === $message->Event) {
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
        } catch (\Exception $e) {
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
    public function update($fan, $wechatUser)
    {
        if ($fan->unionid != $wechatUser->unionid) {
            $fan->unionid = $wechatUser->unionid;
        }

        if ($fan->sex != $wechatUser->sex) {
            $fan->sex = $wechatUser->sex;
        }

        if ($fan->language != $wechatUser->language) {
            $fan->language = $wechatUser->language;
        }

        if ($fan->city != $wechatUser->city) {
            $fan->city = $wechatUser->city;
        }

        if ($fan->province != $wechatUser->province) {
            $fan->province = $wechatUser->province;
        }

        if (empty($fan->headimgurl) && $fan->headimgurl != $wechatUser->headimgurl) {
            $fan->headimgurl = $wechatUser->headimgurl;
        }

        $fan->save();
    }

    public function create($wechatUser)
    {
        $fan = new Fan();

        $fan->forceFill([
            'is_subscribe' => $wechatUser->subscribe,
            'groupid' => $wechatUser->groupid,
            'openid' => $wechatUser->openid,
            'unionid' => $wechatUser->unionid,
            'is_subscribe' => $wechatUser->nickname,
            'sex' => $wechatUser->sex,
            'language' => $wechatUser->language,
            'city' => $wechatUser->city,
            'province' => $wechatUser->province,
            'country' => $wechatUser->country,
            'headimgurl' => $wechatUser->headimgurl,
            'remark' => $wechatUser->remark,
            'subscribed_time' => date('Y-m-d H:i:s', $wechatUser->subscribe_time),
        ])->save();

        return $fan;
    }

    public function config(Request $request)
    {
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
        if(empty($path)) {
            return '/images/avatar/1.png';
        }

        $urlArr = parse_url($path);

        if(empty($urlArr)) {
            return '/images/avatar/1.png';
        }

        $url = ( isset($urlArr['scheme']) && 'http' === $urlArr['scheme'] ? 'http' : 'https') . '://' . $urlArr['host'];

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
