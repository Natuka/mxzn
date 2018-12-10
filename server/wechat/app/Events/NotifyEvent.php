<?php
/**
 * Created by PhpStorm.
 * User: natuka
 * Date: 2018-12-10
 * Time: 22:06
 */

namespace App\Events;

use App\Models\Engineer;
use App\Models\ServiceOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class NotifyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * @var null|ServiceOrder
     */
    protected $order = null;

    /**
     * @var null|Engineer
     */
    protected $engineer = null;

    public function __construct(ServiceOrder $order, Engineer $engineer)
    {
        $this->order = $order;
        $this->engineer = $engineer;
    }

    /**
     * @return Engineer|null
     */
    public function getEngineer(): ?Engineer
    {
        return $this->engineer;
    }

    /**
     * @return ServiceOrder|null
     */
    public function getOrder(): ?ServiceOrder
    {
        return $this->order;
    }

    public function getFan()
    {
        return $this->engineer->fan();
    }
}
