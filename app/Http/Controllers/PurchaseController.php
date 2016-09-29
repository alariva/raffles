<?php

namespace App\Http\Controllers;

use App\Raffle;

class PurchaseController extends Controller
{
    public function index(Raffle $raffle)
    {
        logger()->info("PURCHASE INDEX {$raffle->slug}");

        $purchasesHashes = session('cart.purchases');

        $purchases = $raffle->purchases()->whereIn('hash', $purchasesHashes)->get();

        return view('purchases.index', compact('raffle', 'purchases'));
    }

    public function status(Raffle $raffle, $hash)
    {
        logger()->info("PURCHASE STATUS {$raffle->slug} HASH:{$hash}");

        $purchase = $raffle->purchases()->whereHash($hash)->first();

        if (!$purchase) {
            return redirect()->route('raffle.home', $raffle);
        }

        return view('purchases.status', compact('raffle', 'purchase'));
    }
}
