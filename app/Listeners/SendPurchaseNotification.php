<?php

namespace App\Listeners;

use App\Events\CouponWasPurchased;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @return void
     */
    public function handle(CouponWasPurchased $event)
    {
        logger()->info('Event CouponWasPurchased');
    }
}
