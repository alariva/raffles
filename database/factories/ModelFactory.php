<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Raffle::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->name,
        'slug'         => str_slug($faker->name),
        'description'  => $faker->text,
        'closed_at'    => Carbon\Carbon::now()->addDays(30)->toDateString(),
        'range'        => '0-10',
        'redirect_url' => 'http://example.org/thanks',
    ];
});

$factory->define(App\Coupon::class, function (Faker\Generator $faker) {
    static $number;

    return [
        'raffle_id' => factory(App\Raffle::class)->create()->id,
        'number'    => $number = $faker->numberBetween(0,10),
        'code'      => $number,
        'status'    => 'R',
    ];
});
