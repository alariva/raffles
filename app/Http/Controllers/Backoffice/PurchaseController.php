<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Raffle;

class PurchaseController extends Controller
{
    public function index(Raffle $raffle, $password)
    {
        if ($this->passwordIsValid($raffle->slug, $password)) {
            abort(403);
        }

        logger()->info("BACKOFFICE PURCHASE INDEX {$raffle->slug}");

        $purchases = $raffle->purchases()->get()->toArray();

        $data = array_map(function ($item) {
            return array_only($item, ['hash', 'created_at', 'expires_at', 'status', 'url', 'price']);
        }, $purchases);

        return view('backoffice.purchases.index', compact('raffle', 'data'));
    }

    protected function passwordIsValid($slug, $password)
    {
        return $password != md5(date('Ym').'*'.strtoupper($slug));
    }
}
