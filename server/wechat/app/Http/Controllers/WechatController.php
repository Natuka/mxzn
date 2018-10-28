<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        try {
            $app = app('wechat.official_account');
            $app->server->push(function($message){
                $user = WechatFan::infoByOpenid($message->FromUserName);
                $wechatUser = null;
                if (!$user) {
                    $wechatUser = app('wechat')->user->get($message->FromUserName);
                    $user = $this->createOrUpdateWeixinFan($wechatUser);
                }
                // 绑定之后现在改为创建一个用户资料
                $weixinUser = $this->createOrUpdateMember($user);
                $this->setMember($weixinUser);
                $this->setWeixinUser($user);

                switch ($message->MsgType) {
                    case 'event':
                        // 关注
                        if ('subscribe' === $message->Event) {
                            // 如果是重新關注，那麼需要重新更新微信關注者的資料
                            if (!$wechatUser) {
                                $wechatUser = app('wechat')->user->get($message->FromUserName);
                                // 更新微信資料
                                $this->updateWeixinFan($wechatUser, $user);
                                // 更新微信頭像
                                $this->updateMember($user, $weixinUser);
                            }


                            // 扫描二维码进来
                            if (strpos($message->EventKey, 'qrscene_') !== false) {
                                $screenId = (int) trim($message->EventKey, 'qrscene_');
                                if ($screenId) {
                                    $this->updateUserRecommend($screenId, $weixinUser, $user);
                                }
                            }
                            $user->subscribe = 1;
                            $user->subscribed_at = date('Y-m-d H:i:s', time());
                            $user->save();
                            // 會員未註冊，或者手機號未關聯時
                            // 或者未產生用戶，產生的用戶未綁定手機號
                            return ''; //客户要求直接在微信后台编辑欢迎信息,180125 byltf
//                            if (!$user->mobile || !$weixinUser || !$weixinUser->acct) {
//                                return sprintf('亲爱的%s , 感谢您的关注！您尚未注册，注册后可免费找工作，也可推荐好友找工作并领取推荐费200元 !推荐满15人还送299元耳机，还等啥呢？火速注册吧！[<a href="%s">注册</a>]',
//                                    $user->nickname,
//                                    asset('wxmenu/bind?openid='.$message->FromUserName));
//                            }
//
//                            return '感谢您的关注！';
                        }

                        // 取消关注
                        if ('unsubscribe' === $message->Event) {
                            $user->subscribe = 0;
                            $user->unsubscribe_at = $user->subscribed_at = date('Y-m-d H:i:s', time());
                            $user->save();
                        }

                        // 点击事件
                        if ('CLICK' === $message->Event) {
                            // QrCode
                            if ('qrcode' === $message->EventKey) {
                                return $this->createOrUpdateQrcode();
                            }
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
}
