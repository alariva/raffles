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
            'name'        => 'Dojo Ken Villa Martelli',
            'slug'        => 'dkvm',
            'description' => 'Bienvenidos',
            'opened_at'   => Carbon::now()->addMinutes(2),
            'closed_at'   => Carbon::now()->addDays(30),
            'email'       => 'alariva@gmail.com',
            'range'       => '0-999',
            ]);
    }
}
