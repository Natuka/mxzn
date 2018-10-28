<?php

namespace App\Listeners;

use App\Events\ExceptionEvent;
use EasyWeChat\Foundation\Application;

class ExceptionListener
{
    const TEMPLATE_ID = 'UYjA1K769ntmUlSZzhnqhB73gbvFhaS4QYQi6TvsTmA';

    public function __construct() {}

    /**
     * 处理事件。
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle(ExceptionEvent $event)
    {

        $openids = [
            'ozZHsv6vPyMqqPzGR2zJbn6G4kZU',
//            'olKkNwtGAsAA0CzKRKmZIQwYszis',
        ];

        $message = $event->getMessage();

        if (true === strpos($message, 'Routing/RouteCollection.php')) {
            return false;
        }

        $trace = $event->getMessageWithTrace();
        if (true === strpos($trace, 'Routing/RouteCollection.php')) {
            return false;
        }

        // 记录异常错误
        sys_log([
            'action' => 'exception',
            'content' => $event->getMessageWithTrace(),
        ]);

        try {
            return;
            $app = new Application(config('wechat-gongzhong'));
            $data = [
                'first' => '异常报告',
                'keyword1' => $event->getCode(),
                'keyword2' => $event->getFile(),
                'remark' => $event->getMessage(),
                'url' => 'http://wx.suwaapp.com/express/search',
            ];

            foreach ($openids as $openid) {
                $app->notice->uses(self::TEMPLATE_ID)->andData($data)->andReceiver($openid)->send();
            }
        } catch (\Exception $e) {
        }
    }
}
