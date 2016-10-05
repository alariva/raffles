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
    $name = $faker->name;

    return [
        'name'         => $name,
        'slug'         => str_slug($name),
        'description'  => $faker->text,
        'opened_at'    => Carbon\Carbon::now()->subDays(1)->toDateString(),
        'closed_at'    => Carbon\Carbon::now()->addDays(30)->toDateString(),
        'range'        => '0-10',
        'email'        => $faker->email,
        'redirect_url' => 'http://example.org/thanks',
    ];
});

$factory->define(App\Coupon::class, function (Faker\Generator $faker) {
    $number = $faker->numberBetween(0, 10);
    $code = str_pad($number, 3, '0', STR_PAD_LEFT);

    return [
        'raffle_id'   => factory(App\Raffle::class)->create()->id,
        'number'      => $number,
        'code'        => $code,
        'purchase_id' => null,
        'status'      => 'R',
        'notes'       => null,
    ];
});
