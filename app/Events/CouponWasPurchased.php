<?php

namespace App\Events;

use App\Raffle;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class CouponWasPurchased
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Raffle
     */
    public $raffle;

    /**
     * @var array
     */
    public $ticket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Raffle $raffle, array $ticket)
    {
        $this->raffle = $raffle;

        $this->ticket = $ticket;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('purchases');
    }
}
