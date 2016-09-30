<?php

namespace App\Http\Controllers;

use App\Raffle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RaffleController extends Controller
{
    public function home(Raffle $raffle)
    {
        logger()->info("HOME:{$raffle->slug}");

        session()->put('cart.raffle', $raffle);
        session()->put('cart.numbers', []);

        Carbon::setLocale('es');

        $terms = $this->loadTermsAndConditions($raffle->slug);

        $reservedCount = $raffle->coupons()->where('status', '<>', 'F')->count();

        return view('raffles.home', compact('raffle', 'reservedCount', 'terms'));
    }

    protected function loadTermsAndConditions($slug)
    {
        $file = "raffles/{$slug}/terms.md";
        if (!Storage::exists($file)) {
            return;
        }

        return Storage::get($file);
    }
}
