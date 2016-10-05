<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseWorkflowTest extends TestCase
{
    use DatabaseTransactions;
    use CreateRaffle, CreateCoupon;

    /**
     * @var \App\Raffle
     */
    protected $raffle;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_purchase_a_coupon()
    {
        $this->arrangeScenario();
        $this->actingAs(new User(), 'web');

        $this->visitHome();

        $this->accessCoupons();

        $this->pickCoupon('000');
        $this->pickCoupon('002');

        $this->checkout();

        # $cart = session('cart');
        # dd($cart);
    }

    protected function visitHome()
    {
        $this->visit(route('raffle.home', $this->raffle));
        $this->see($this->raffle->slug);
    }

    protected function accessCoupons()
    {
        $this->visit(route('coupons.browse', $this->raffle));
        foreach ($this->raffle->coupons as $coupon) {
            $this->see($coupon->code);
        }
    }

    protected function pickCoupon($coupon)
    {
        $this->see("$coupon");

        $this->visit(route('coupons.add', $coupon));

        $this->see("$coupon");
    }

    protected function checkout()
    {
        $this->visit(route('coupons.checkout', $this->raffle));

        $this->see('000');
        $this->see('002');

        $this->type('John Doe', 'name');
        $this->type('test@email.org', 'email');
        $this->type('123456789', 'tel');
        $this->type('My City, Mars', 'city');
        $this->check('accept_terms');

        $this->press('Confirmar');

        $this->seePageIs($this->raffle->slug.'/confirm');
    }

    protected function arrangeScenario()
    {
        $this->raffle = $this->createRaffle();

//        for ($i = 0; $i < 2; $i++) {
//            $coupon = $this->makeCoupon(['number' => $i, 'code' => str_pad($i, 3, '0', STR_PAD_LEFT), 'status' => 'F']);
//            $this->raffle->coupons()->save($coupon);
//        }
    }
}
