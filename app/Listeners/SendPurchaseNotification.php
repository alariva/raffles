<?php

namespace App\Listeners;

use App\Events\CouponWasPurchased;
use App\Purchase;
use App\Raffle;
use Carbon\Carbon;

class SendPurchaseNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CouponWasPurchased  $event
     *
     * @return void
     */
    public function handle(CouponWasPurchased $event)
    {
        logger()->info('Event CouponWasPurchased');

        $this->createPurchase($event->raffle, $event->coupons, $event->ticket);
    }

    protected function createPurchase(Raffle $raffle, $coupons, $ticket)
    {
        $purchase = $raffle->purchases()->create([
            'hash'       => array_get($ticket, 'hash'),
            'status'     => Purchase::STATUS_RESERVED,
            'price'      => array_get($ticket, 'price'),
            'details'    => json_encode($ticket),
            'url'        => array_get($ticket, 'url'),
            'expires_at' => Carbon::now()->addDays(3),
            ]);

        $purchase->coupons()->saveMany($coupons);
    }
}
