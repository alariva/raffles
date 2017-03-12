<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Coupon;
use App\Events\CouponWasPurchased;
use App\Raffle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SinglepageController extends Controller
{
    protected $dealer;

    public function __construct()
    {
        $this->dealer = new RaffleDealer();
    }

    public function home(Raffle $raffle)
    {
        logger()->info("HOME:{$raffle->slug}");

        session()->put('cart.raffle', $raffle);
        session()->put('cart.numbers', []);

        Carbon::setLocale('es');

        $terms = $this->loadTermsAndConditions($raffle->slug);

        $reservedCount = $raffle->coupons()->where('status', '<>', 'F')->count();

        $price = $raffle->getPreference('price.individual');

        return view('raffles.singlepage', compact('raffle', 'reservedCount', 'price', 'terms'));
    }

    protected function loadTermsAndConditions($slug)
    {
        $file = "raffles/{$slug}/terms.md";
        if (!Storage::exists($file)) {
            return;
        }

        return Storage::get($file);
    }

    public function directconfirm(Raffle $raffle, Request $request)
    {
        if ($raffle->opened_at->isFuture() || $raffle->closed_at->isPast()) {
            logger()->info('ADVICE: RAFFLE IS NOT ACTIVE:'.serialize($raffle));

            return redirect()->route('raffle.home', $raffle)->withErrors('La campaña no está activa');
        }
        
        $ticket = $request->only(['name', 'email', 'tel', 'city', 'contactme', 'accept_terms']);

        $coupons = collect($this->dealer->setRaffle($raffle)->browse());

        $number = $coupons->first();

        logger()->info('CHECKOUT CONFIRM ATTEMPT:'.serialize($ticket));

        $this->validate($request, [
            'accept_terms' => 'required|in:yes',
            'dni'          => 'required|max:8',
            'name'         => 'required|max:255',
            'email'        => 'required|email',
            'tel'          => 'required|max:16',
            'city'         => 'required|max:100',
        ]);

        if ($number === null) {
            logger()->info('ADVICE: No more coupons available');

            return redirect()->route('raffle.home', $raffle)->withErrors('No hay más cupones disponibles');
        }

        $numbers = [$number];

        array_set($ticket, 'numbers', $numbers);

        logger()->info('CHECKOUT CONFIRMED: '.serialize($ticket));

        $coupons = $this->reserveCoupons($raffle, $numbers, array_get($ticket, 'name'));

        $count = count($coupons);

        $price = $this->calculatePrice($raffle, $count);

        logger()->info("CHECKOUT CALCULATED PRICE IS: {$price}");

        $paymentUrl = $this->generatePaymentUrl($raffle->slug, $numbers, $price);

        $hash = md5($paymentUrl);

        array_set($ticket, 'price', $price);
        array_set($ticket, 'url', $paymentUrl);
        array_set($ticket, 'hash', $hash);

        session()->push('cart.purchases', $hash);

        event(new CouponWasPurchased($raffle, $coupons, $ticket));

        $purchase = $raffle->purchases()->whereHash($hash)->first();

        return view('purchases.status', compact('raffle', 'purchase'));
    }

    protected function reserveCoupons(Raffle $raffle, array $numbers, $notes = null)
    {
        $coupons = [];
        foreach ($numbers as $number) {
            $coupon = new Coupon([
                'number' => $number,
                'code'   => $number,
                'status' => 'R',
                'notes'  => $notes,
                ]);
            $raffle->coupons()->save($coupon);
            $coupons[] = $coupon;
        }
        return $coupons;
    }

    protected function calculatePrice(Raffle $raffle, $count)
    {
        $individualPrice = $raffle->getPreference('individual.price', 30); // Currency
        $comboPrice = $raffle->getPreference('combo.price', 50); // Currency

        $comboNumber = $raffle->getPreference('combo.number', 2); // Number of elements

        return $count % $comboNumber * $individualPrice + floor($count / $comboNumber) * $comboPrice;
    }

    protected function generatePaymentUrl($prefix, $coupons, $price)
    {
        $count = count($coupons);

        $prefix = strtoupper($prefix);

        // id=516862&precio=15,30&venc=7&codigo=15&hacia=website2@website2.com&concepto=hosting plan 4
        $query = http_build_query([
            'id'       => 516862,
            'precio'   => $price,
            'venc'     => 3,
            'codigo'   => 'COUPONIC-'.$prefix.'-'.implode(',', $coupons),
            'concepto' => $count.' talones: '.implode(',', $coupons),
            ]);

        $paymentUrl = "https://www.cuentadigital.com/api.php?{$query}";

        logger()->info("GENERATED PAYMENT URL:{$paymentUrl}");

        return $paymentUrl;
    }
}
