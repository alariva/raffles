<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Coupon;
use App\Raffle;

class RaffleController extends Controller
{
    public function home(Raffle $raffle)
    {
        session()->put('cart.numbers', []);

        return view('raffles.home', compact('raffle'));
    }
}
