<?php

use App\CORE\RaffleDealer;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RaffleDealerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_provides_numbers_list_to_browse()
    {
        $raffle = factory(App\Raffle::class)->create();

        $couponOne = factory(App\Coupon::class)->create();

        $couponTwo = factory(App\Coupon::class)->create();

        $couponThree = factory(App\Coupon::class)->create();

        $raffle->coupons()->save($couponOne);
        $raffle->coupons()->save($couponTwo);
        $raffle->coupons()->save($couponThree);

        $dealer = new RaffleDealer($raffle);

        $list = $dealer->browse();

        $this->assertFalse(in_array($couponOne->number, $list));
        $this->assertFalse(in_array($couponTwo->number, $list));
        $this->assertFalse(in_array($couponThree->number, $list));
    }

    public function test_checks_number_availability()
    {
        $raffle = factory(App\Raffle::class)->create();

        $couponOne = factory(App\Coupon::class)->create([
            'number' => 3,
            ]);

        $couponTwo = factory(App\Coupon::class)->create([
            'number' => 7,
            ]);

        $couponThree = factory(App\Coupon::class)->create([
            'number' => 8,
            'status' => 'F',
            ]);

        $raffle->coupons()->save($couponOne);
        $raffle->coupons()->save($couponTwo);
        $raffle->coupons()->save($couponThree);

        $dealer = new RaffleDealer($raffle);

        $this->assertFalse($dealer->isAvailable($couponOne->number));
        $this->assertFalse($dealer->isAvailable($couponTwo->number));
        $this->assertTrue($dealer->isAvailable($couponThree->number));
    }
}
