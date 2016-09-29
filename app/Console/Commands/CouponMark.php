<?php

namespace App\Console\Commands;

use App\CORE\Range;
use App\Raffle;
use Illuminate\Console\Command;

class CouponMark extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:mark {raffle} {range} {status} {--notes=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark coupon with status';

    protected $range;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->range = new Range();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $raffleSlug = $this->argument('raffle');

        $rangeString = $this->argument('range');

        $status = $this->argument('status');

        $notes = $this->option('notes', null);

        $raffle = Raffle::whereSlug($raffleSlug)->firstOrFail();

        $numbers = $this->range->create($rangeString)->get();

        foreach ($numbers as $number) {
            $this->info("NUMBER {$number} SET TO {$status}");
            $raffle->coupons()->updateOrCreate([
                'number' => $number,
                ], [
                'code'   => str_pad($number, 3, '0', STR_PAD_LEFT),
                'status' => $status,
                'notes'  => $notes,
                ]);
        }

        $this->info('DONE');
    }
}
