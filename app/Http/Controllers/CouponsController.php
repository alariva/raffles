<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Http\Requests;
use App\Raffle;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function browse(Raffle $raffle)
    {
        $dealer = new RaffleDealer($raffle);

        $coupons = $dealer->browse();

        return view('coupons', compact('coupons'));
    }
}
