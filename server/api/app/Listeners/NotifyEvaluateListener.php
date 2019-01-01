<?php
/**
 * Created by PhpStorm.
 * User: natuka
 * Date: 2018-12-10
 * Time: 22:06
 */

namespace App\Listeners;


use App\Events\NotifyEvaluateEvent;

class NotifyEvaluateListener
{
    const TEMPLATE_ID = 'McTtPR3jCqQDKxvKeNmqiUz5GmYCyyTcBjM4HVsfprs';

    public function handle(NotifyEvaluateEvent $event)
    {
        $order = $event->getOrder();

        $fan = $event->getFan();
        if (!$fan) {
            return;
        }

        $repair = $order->repairs()->first();

        $app = \EasyWeChat::officialAccount();
        $ret = $app->template_message->send([
            'touser' => $fan->openid,
            'template_id' => self::TEMPLATE_ID,
            'url' => 'https://mp.mxhj.net/menu/evaluate/' . $order->id,
            'data' => [
                'first' => '尊敬的客户，您的本次服务已经完成！',
                'keyword1' => $order->number,
                'keyword2' => $repair ? $repair->created_at : $order->updated_at,
                'remark' => '感谢您对我们的支持，您可以对本次服务的评价!',

            ],
        ]);

        \Log::info([
            'type' => 'send template',
            'info' => $ret,
        ]);
    }
}
