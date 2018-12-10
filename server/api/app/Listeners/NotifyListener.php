<?php
/**
 * Created by PhpStorm.
 * User: natuka
 * Date: 2018-12-10
 * Time: 22:06
 */

namespace App\Listeners;


use App\Events\NotifyEvent;

class NotifyListener
{
    const TEMPLATE_ID = 'ervgoW5vRARwEqE7yDDUZlnS4trOVmiuDuZFx4fjAxI';

    public function handle(NotifyEvent $event)
    {
        $order = $event->getOrder();
        $engineer = $event->getEngineer();
        $fan = $event->getFan();

        // 没有，或者取消关注，无法获取到推送
        if (!$fan || !$fan->is_subscribe) {
            \Log::info([
                'type'=> 'not fan or not subscribe',
                'info' => $fan,
            ]);
            return;
        }

        $customer = $order->customer;
        $fault = $order->fault()->first();

        $app = \EasyWeChat::officialAccount();
        $ret = $app->template_message->send([
            'touser' => $fan->openid,
            'template_id' => self::TEMPLATE_ID,
            'url' => 'https://mp.mxhj.net/repair/detail?id=' . $order->id,
            'data' => [
                'first' => '您领取了新的工单！',
                'keyword1' => $order->number,
                'keyword2' => $order->is_out ? '上门' : '',
                'keyword3' => $customer->name,
                'keyword4' => $fault ? $fault->desc : '',
                'keyword5' => $engineer->name,
                'remark' => '点击查看详情',

            ],
        ]);

        \Log::info([
            'type'=> 'send template',
            'info' => $ret,
        ]);
    }
}
