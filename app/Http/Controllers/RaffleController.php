<?php

namespace App\Http\Controllers;

use App\Raffle;

class RaffleController extends Controller
{
    public function home(Raffle $raffle)
    {
        session()->put('cart.raffle', $raffle);
        session()->put('cart.numbers', []);

        return view('raffles.home', compact('raffle'));
    }
}
