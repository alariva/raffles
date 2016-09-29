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
        $raffle = session('cart.raffle');

        session()->put('cart.numbers', []);

        return redirect()->route('coupons.browse', $raffle);
    }

    public function browse(Raffle $raffle)
    {
        $selected = session('cart.numbers');

        $coupons = collect($this->dealer->setRaffle($raffle)->browse());

        $count = count($coupons);

        return view('coupons', compact('raffle', 'coupons', 'count', 'selected'));
    }

    public function add($number)
    {
        $raffle = session('cart.raffle');

        if (!$this->couponsAreAvailable($raffle, $number)) {
            return redirect()->route('coupons.browse', $raffle)->withError("El numero {$number} ya fue reservado");
        }

        session()->push('cart.numbers', $number);

        $numbers = session('cart.numbers');

        if (count($numbers) >= 2) {
            return redirect()->route('coupons.checkout', $raffle);
        }

        return redirect()->route('coupons.browse', $raffle);
    }

    public function checkout(Raffle $raffle)
    {
        $coupons = session('cart.numbers');

        if (!$this->couponsAreAvailable($raffle, $coupons)) {
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
            return redirect()->route('raffle.home', $raffle)->withError('Al menos uno de los numeros ya fue reservado');
        }

        logger()->info('CONFIRMED CHECKOUT: '.serialize($ticket));

        $this->reserveCoupons($raffle, $coupons);

        $count = count($coupons);

        $price = $this->calculatePrice($count);

        // id=516862&precio=15,30&venc=7&codigo=15&hacia=website2@website2.com&concepto=hosting plan 4
        $query = http_build_query([
            'id'       => 516862,
            'precio'   => $price,
            'venc'     => 3,
            'codigo'   => 'TR-DKVM-'.implode(',', $coupons),
            'concepto' => $count.' talones: '.implode(',', $coupons),
            ]);

        dd('Debug: Cool, you made it');

        return redirect()->to("https://www.cuentadigital.com/api.php?{$query}");
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
