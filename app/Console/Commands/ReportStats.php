<?php

namespace App\Console\Commands;

use App\Purchase;
use App\Raffle;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReportStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:stats {raffle}';

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
        $raffleSlug = $this->argument('raffle');

        $raffle = Raffle::whereSlug($raffleSlug)->firstOrFail();

        $purchases = $raffle->purchases;
        $purchasesReserved = $raffle->purchases()->whereStatus(Purchase::STATUS_RESERVED)->get();
        $purchasesPaid = $raffle->purchases()->whereStatus(Purchase::STATUS_PAID)->get();

        $this->info('Purchases');

        $headers = ['Date', 'Reserved Count', 'Reserved Price', 'Paid Count', 'Paid Price'];

        $data = [
            'Date'           => Carbon::now()->timezone('America/Argentina/Buenos_Aires')->toDateString(),
            'Reserved Count' => $purchasesReserved->count(),
            'Reserved Price' => $purchasesReserved->sum('price'),
            'Paid Count'     => $purchasesPaid->count(),
            'Paid Price'     => $purchasesPaid->sum('price'),
        ];

        $this->table($headers, [$data]);

        $totalCount = $data['Reserved Count'] + $data['Paid Count'];
        $totalPrice = $data['Reserved Price'] + $data['Paid Price'];

        $this->info("Total: {$totalCount} Price: {$totalPrice}");
    }
}
