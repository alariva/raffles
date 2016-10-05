<?php

use App\Raffle;

trait CreateRaffle
{
    private function createRaffles($count, $overrides = [])
    {
        return factory(Raffle::class, $count)->create($overrides);
    }

    private function createRaffle($overrides = [])
    {
        return factory(Raffle::class)->create($overrides);
    }

    private function makeRaffle()
    {
        return factory(Raffle::class)->make();
    }
}
