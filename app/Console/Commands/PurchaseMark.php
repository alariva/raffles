<?php

namespace App\Console\Commands;

use App\Purchase;
use App\Raffle;
use Illuminate\Console\Command;

class PurchaseMark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:mark {raffle} {hash} {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark purchases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $raffleSlug = $this->argument('raffle');

        $raffle = Raffle::whereSlug($raffleSlug)->firstOrFail();

        $status = $this->argument('status');

        $hash = $this->argument('hash');

        $purchase = $raffle->purchases()->whereHash($hash)->firstOrFail();

        $this->markPurchase($purchase, $status);
    }

    protected function markPurchase($purchase, $status)
    {
        foreach ($purchase->coupons as $coupon) {
            $this->info("Coupon {$coupon->code} of {$purchase->hash} marked [{$coupon->status} => {$status}]");
            $coupon->status = $status;
            $coupon->save();
        }

        $this->info("Purchase {$purchase->hash} marked [{$purchase->status} => {$status}]");
        $purchase->status = $status;
        $purchase->save();
    }
}
