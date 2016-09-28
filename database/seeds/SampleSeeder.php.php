<?php

use App\Raffle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Raffle::create([
            'name' => 'Dojo Ken Villa Martelli',
            'slug' => 'dkvm',
            'description' => 'blah',
            'closed_at' => Carbon::now()->addDays(30),
            'range' => '1-100'
            ]);
    }
}
