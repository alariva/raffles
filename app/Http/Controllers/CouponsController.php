<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Coupon;
use App\Raffle;
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
        logger()->info("Cart reset");

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

    public function add($number)
    {
        $raffle = session('cart.raffle');

        if (!$this->couponsAreAvailable($raffle, $number)) {
            logger()->info("ADVICE: INDIVIDUAL COLLISION: The coupon is already taken:{$number}, redirecting back");
            return redirect()->route('coupons.browse', $raffle)->withError("El numero {$number} ya fue reservado");
        }

        session()->push('cart.numbers', $number);

        logger()->info("ADDED TO CART: {$number}");

        $numbers = session('cart.numbers');

        if (count($numbers) >= 2) {
            logger()->info("AUTOREDIRECTING TO CHECKOUT");
            return redirect()->route('coupons.checkout', $raffle);
        }

        logger()->info("REDIRECTING BACK TO BROWSE");
        return redirect()->route('coupons.browse', $raffle);
    }

    public function checkout(Raffle $raffle)
    {
        logger()->info("CHECKOUT");

        $coupons = session('cart.numbers');

        if (!$this->couponsAreAvailable($raffle, $coupons)) {
            logger()->info('ADVICE: COMPOUND COLLISION (checkout): At least one of the coupons is already taken:'.serialize($coupons));
            return redirect()->route('raffle.home', $raffle)->withError('Al menos uno de los numeros ya fue reservado');
        }

        $price = $this->calculatePrice(count($coupons));

        return view('checkout', compact('raffle', 'coupons', 'price'));
    }

    public function confirm(Raffle $raffle, Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => 'required|email',
            'tel'       => 'required|max:16',
            'city'      => 'required|max:100',
        ]);

        $ticket = $request->only(['name', 'email', 'tel', 'city']);

        $coupons = session('cart.numbers');

        $ticket['numbers'] = $coupons;

        if (!$this->couponsAreAvailable($raffle, $coupons)) {
            logger()->info('ADVICE: COMPOUND COLLISION (confirm): At least one of the coupons is already taken:'.serialize($coupons));
            return redirect()->route('raffle.home', $raffle)->withError('Al menos uno de los numeros ya fue reservado');
        }

        logger()->info('CHECKOUT CONFIRMED: '.serialize($ticket));

        $this->reserveCoupons($raffle, $coupons);

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

        $url = "https://www.cuentadigital.com/api.php?{$query}";

        logger()->info("CHECKOUT REDIRECT TO INVOICE:{$url}");

        dd('Debug: Cool, you made it');

        return redirect()->to($url);
    }

    protected function reserveCoupons(Raffle $raffle, array $coupons)
    {
        foreach ($coupons as $coupon) {
            $coupon = new Coupon([
                'number' => $coupon,
                'status' => 'R',
                ]);
            $raffle->coupons()->save($coupon);
        }
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
}
