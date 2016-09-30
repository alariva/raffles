<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Coupon;
use App\Events\CouponWasPurchased;
use App\Raffle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    protected $dealer;

    public function __construct()
    {
        $this->dealer = new RaffleDealer();
    }

    public function reset()
    {
        logger()->info('Cart reset');

        $raffle = session('cart.raffle');

        session()->put('cart.numbers', []);

        return redirect()->route('coupons.browse', $raffle);
    }

    public function browse(Raffle $raffle)
    {
        logger()->info("BROWSE {$raffle->slug}");

        $selected = session('cart.numbers');

        $coupons = collect($this->dealer->setRaffle($raffle)->browse());

        $count = count($coupons);

        return view('coupons', compact('raffle', 'coupons', 'count', 'selected'));
    }

    public function status(Raffle $raffle, $numbers)
    {
        logger()->info("STATUS {$raffle->slug} NUMBERS:{$numbers}");

        $coupons = $raffle->coupons()->whereIn('number', explode(',', $numbers))->get();

        return view('coupons-status', compact('raffle', 'coupons'));
    }

    public function add($number)
    {
        $raffle = session('cart.raffle');

        if (!$this->couponsAreAvailable($raffle, $number)) {
            logger()->info("ADVICE: INDIVIDUAL COLLISION: The coupon is already taken:{$number}, redirecting back");

            return redirect()->route('coupons.browse', $raffle)->withErrors("El numero {$number} ya fue reservado");
        }

        session()->push('cart.numbers', $number);

        logger()->info("ADDED TO CART: {$number}");

        $numbers = session('cart.numbers');

        if (count($numbers) >= 2) {
            logger()->info('AUTOREDIRECTING TO CHECKOUT');

            return redirect()->route('coupons.checkout', $raffle);
        }

        logger()->info('REDIRECTING BACK TO BROWSE');

        return redirect()->route('coupons.browse', $raffle);
    }

    public function checkout(Raffle $raffle)
    {
        logger()->info('CHECKOUT');

        $coupons = session('cart.numbers');

        if (!$this->couponsAreAvailable($raffle, $coupons)) {
            logger()->info('ADVICE: COMPOUND COLLISION (checkout): At least one of the coupons is already taken:'.serialize($coupons));

            return redirect()->route('raffle.home', $raffle)->withErrors('Al menos uno de los numeros ya fue reservado');
        }

        $price = $this->calculatePrice(count($coupons));

        return view('checkout', compact('raffle', 'coupons', 'price'));
    }

    public function confirm(Raffle $raffle, Request $request)
    {
        if ($raffle->opened_at->isFuture() || $raffle->closed_at->isPast()) {
            logger()->info('ADVICE: RAFFLE IS NOT ACTIVE:'.serialize($raffle));

            return redirect()->route('raffle.home', $raffle)->withErrors('La rifa no está activa');
        }
        
        $ticket = $request->only(['name', 'email', 'tel', 'city', 'contactme', 'accept_terms']);

        logger()->info('CHECKOUT CONFIRM ATTEMPT:'.serialize($ticket));

        $this->validate($request, [
            'accept_terms' => 'required|in:yes',
            'name'         => 'required|max:255',
            'email'        => 'required|email',
            'tel'          => 'required|max:16',
            'city'         => 'required|max:100',
        ]);

        $numbers = session('cart.numbers');

        array_set($ticket, 'numbers', $numbers);

        if (!$this->couponsAreAvailable($raffle, $numbers)) {
            logger()->info('ADVICE: COMPOUND COLLISION (confirm): At least one of the coupons is already taken:'.serialize($numbers));

            return redirect()->route('raffle.home', $raffle)->withErrors('Al menos uno de los numeros ya fue reservado');
        }

        logger()->info('CHECKOUT CONFIRMED: '.serialize($ticket));

        $coupons = $this->reserveCoupons($raffle, $numbers, array_get($ticket, 'name'));

        $paymentUrl = $this->generatePaymentUrl($numbers);

        $hash = md5($paymentUrl);

        array_set($ticket, 'url', $paymentUrl);
        array_set($ticket, 'hash', $hash);

        session()->push('cart.purchases', $hash);

        event(new CouponWasPurchased($raffle, $coupons, $ticket));

        $purchase = $raffle->purchases()->whereHash($hash)->first();

        return view('purchases.status', compact('purchase'));
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

    protected function calculatePrice($count)
    {
        $individualPrice = 30; // Currency
        $comboPrice = 50; // Currency

        $comboNumber = 2; // Number of elements

        return $count % $comboNumber * $individualPrice + floor($count / $comboNumber) * $comboPrice;
    }

    protected function couponsAreAvailable(Raffle $raffle, $coupons)
    {
        if (!is_array($coupons)) {
            $coupons = [$coupons];
        }

        foreach ($coupons as $coupon) {
            if (!$this->dealer->setRaffle($raffle)->isAvailable($coupon)) {
                return false;
            }
        }

        return true;
    }

    protected function generatePaymentUrl($coupons)
    {
        $count = count($coupons);

        $price = $this->calculatePrice($count);

        logger()->info("CHECKOUT CALCULATED PRICE IS: {$price}");

        // id=516862&precio=15,30&venc=7&codigo=15&hacia=website2@website2.com&concepto=hosting plan 4
        $query = http_build_query([
            'id'       => 516862,
            'precio'   => $price,
            'venc'     => 3,
            'codigo'   => 'TR-DKVM-'.implode(',', $coupons),
            'concepto' => $count.' talones: '.implode(',', $coupons),
            ]);

        $paymentUrl = "https://www.cuentadigital.com/api.php?{$query}";

        logger()->info("GENERATED PAYMENT URL:{$paymentUrl}");

        return $paymentUrl;
    }
}
