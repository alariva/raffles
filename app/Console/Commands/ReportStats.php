<?php

namespace App\Console\Commands;

use App\Coupon;
use App\Purchase;
use Illuminate\Console\Command;

class ReportStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report stats';

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
        $purchasesCount = Purchase::count();
        $purchasesReservedCount = Purchase::whereStatus(Purchase::STATUS_RESERVED)->count();
        $purchasesPaidCount = Purchase::whereStatus(Purchase::STATUS_PAID)->count();

        $this->info("Purchases: $purchasesCount");
        $this->info("  Reserved: $purchasesReservedCount");
        $this->info("  Paid: $purchasesPaidCount");
    }
}
