<?php

namespace App\Console\Commands;

use App\Raffle;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CouponCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:cleanup {raffle} {--days=3} {--delete=no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup unpaid pending coupons';

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

        $delete = $this->option('delete');

        $days = $this->option('days');

        $raffle = Raffle::whereSlug($raffleSlug)->firstOrFail();

        $coupons = $raffle->coupons()
                          ->where('status', 'R')
                          ->where('created_at', '<', Carbon::now()->subDays($days))
                          ->get();

        foreach ($coupons as $coupon) {
            $this->info("FOUND [{$coupon->code}] {$coupon->status} ({$coupon->number}) AGE:{$coupon->created_at->diffForHumans()} PURCHASE_ID:{$coupon->purchase_id} NOTES:{$coupon->notes}");

            if ($delete == 'yes') {
                $coupon->delete();
                $this->warn("DELETED [{$coupon->code}]");
            }
        }

        $this->info('TOTAL:'.count($coupons));
    }
}
