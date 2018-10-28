<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExceptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Exception
     */
    protected $e = null;
    /**
     * 创建一个新的事件实例。
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct($e)
    {
        $this->e = $e;
    }

    public function getMessage()
    {
        return $this->e->getMessage();
    }

    public function getTraceAsString()
    {
        return $this->e->getTraceAsString();
    }

    public function getMessageWithTrace()
    {
        return $this->getMessage() . PHP_EOL . $this->getTraceAsString();
    }

    public function getCode()
    {
        return $this->e->getCode();
    }

    public function getFile()
    {
        return $this->e->getFile();
    }

    public function getLine()
    {
        return $this->e->getLine();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

}
