<?php

namespace App\Http\Controllers;

use App\Raffle;
use Carbon\Carbon;

class RaffleController extends Controller
{
    public function home(Raffle $raffle)
    {
        session()->put('cart.raffle', $raffle);
        session()->put('cart.numbers', []);

        Carbon::setLocale('es');

        return view('raffles.home', compact('raffle'));
    }
}
