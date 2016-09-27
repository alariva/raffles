<?php

namespace App\CORE;

use App\Coupon;
use App\Raffle;

class RaffleDealer
{
    private $raffle;

    private $range;

    public function __construct($raffle = null)
    {
        if ($raffle) {
            $this->setRaffle($raffle);
        }

        $this->range = new Range();
    }

    public function setRaffle(Raffle $raffle)
    {
        $this->raffle = $raffle;

        return $this;
    }

    // check
    public function isAvailable($number)
    {
        if (!$this->range->valid($this->raffle->range, $number)) {
            return false;
        }

        $coupon = Coupon::whereNumber($number)->whereNotIn('status', ['F'])->first();

        return $coupon === null;
    }

    // pick
    public function pick($number)
    {
        if (!$this->isAvailable($number)) {
            return false;
        }

        $coupon = Coupon::create([
            'number' => $number,
            'status' => 'R',
            ]);

        return $coupon;
    }

    // list
    public function browse()
    {
        $exclusionNumbers = $this->raffle->coupons->pluck('number')->all();

        return $this->range
                    ->create($this->raffle->range)
                    ->exclude($exclusionNumbers)
                    ->pad(4)
                    ->get();
    }
}
