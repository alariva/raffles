<?php

namespace App\Http\Controllers;

use App\CORE\RaffleDealer;
use App\Coupon;
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

        return view('checkout', compact('coupons', 'raffle'));
    }

    public function confirm(Raffle $raffle)
    {
        $coupons = session('cart.numbers');

        $this->reserveCoupons($raffle, $coupons);

        $count = count($coupons);

        $price = $count % 2 * 60 + floor($count / 2) * 40;

        // id=516862&precio=15,30&venc=7&codigo=15&hacia=website2@website2.com&concepto=hosting plan 4
        $query = http_build_query([
            'id' => 516862,
            'precio' => $price,
            'venc' => 3,
            'codigo' => 'RifaDKVM',
            'concepto' => $count.' talones: '.implode(',', $coupons),
            ]);

        return redirect()->to("https://www.cuentadigital.com/api.php?{$query}");
    }

    protected function reserveCoupons(Raffle $raffle, array $coupons)
    {
        foreach ($coupons as $coupon) {
            $coupon = new Coupon([
                'number' => $coupon,
                'status' => 'R'
                ]);
            $raffle->coupons()->save($coupon);
        }
    }
}
