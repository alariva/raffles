<?php

namespace App\Console\Commands;

use App\CORE\RaffleDealer;
use App\Raffle;
use Illuminate\Console\Command;

class CouponBrowse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:browse {raffle}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Browse available coupons';

    /**
     * @var \App\CORE\RaffleDealer
     */
    protected $dealer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->dealer = new RaffleDealer();
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

        $coupons = $this->dealer->setRaffle($raffle)->browse();

        foreach ($coupons as $coupon) {
            $this->info($coupon);
        }
    }
}
