<?php

namespace App\Console\Commands;

use App\Purchase;
use Illuminate\Console\Command;

class PurchaseList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:list {status} {--bycoupon=no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List purchases';

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
        $status = $this->argument('status');

        $purchases = Purchase::whereStatus($status)->get();

        $byCoupon = $this->option('bycoupon') == 'yes';

        $this->printList($purchases, $byCoupon);
    }

    protected function printList($purchases, $byCoupon = false)
    {
        foreach ($purchases as $purchase) {
            $details = json_decode($purchase->details);

            if($byCoupon)
            {
                $this->printCouponList($purchase);
            }
            else
            {
                $this->info("{$purchase->status} {$purchase->hash} {$details->name}");
            }
        }
    }

    protected function printCouponList(Purchase $purchase)
    {
        foreach ($purchase->coupons as $coupon) {
            $details = json_decode($purchase->details);
            $this->info("{$coupon->code};{$purchase->created_at->toDateString()};{$purchase->hash};{$details->name};{$details->email};{$details->tel};{$coupon->status}");
        }
    }
}
