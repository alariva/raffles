<?php

use App\Coupon;

trait CreateCoupon
{
    private function createCoupons($count, $overrides = [])
    {
        return factory(Coupon::class, $count)->create($overrides);
    }

    private function createCoupon($overrides = [])
    {
        return factory(Coupon::class)->create($overrides);
    }

    private function makeCoupon($overrides = [])
    {
        return factory(Coupon::class)->make($overrides);
    }
}
