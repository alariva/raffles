<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Raffle;

class CouponsController extends Controller
{
    public function reset()
    {
        $raffle = session('cart.raffle');

        session()->put('cart.numbers', []);

        return redirect()->route('coupons.browse', $raffle);
    }

    public function browse(Raffle $raffle)
    {
        session(['cart.raffle' => $raffle]);

        $selected = session('cart.numbers');

        $dealer = new RaffleDealer($raffle);

        $coupons = $dealer->browse();

        return view('coupons', compact('coupons', 'selected'));
    }

    public function add($number)
    {
        $raffle = session('cart.raffle');

        session()->push('cart.numbers', $number);

        $numbers = session('cart.numbers');

        if(count($numbers) >= 2)
        {
            return redirect()->route('coupons.checkout', $raffle);
        }

        return redirect()->route('coupons.browse', $raffle);
    }

    public function checkout(Raffle $raffle)
    {
        $coupons = session('cart.numbers');

        return view('checkout', compact('coupons'));
    }
}
