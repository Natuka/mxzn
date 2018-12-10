<?php
/**
 * Created by PhpStorm.
 * User: natuka
 * Date: 2018-12-09
 * Time: 17:03
 */

namespace App\Services;

use EasyWeChat;


class Notify
{
    protected static $instance = null;

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new Notify();
        }

        return self::$instance;
    }


    public function send()
    {
        $officialAccount = EasyWeChat::officialAccount();

        $officialAccount->template_message->send([
            'touser' => 'user-openid',
            'template_id' => 'template-id',
            'url' => 'https://mp.mxhj.net/repair/info',
            'data' => [
                'key1' => 'VALUE',
                'key2' => 'VALUE2',

            ],
        ]);
    }

}
