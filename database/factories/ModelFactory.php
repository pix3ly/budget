<?php

use App\Models\APIKey;
use App\Models\Budget;
use App\Models\ConversionRate;
use App\Models\Currency;
use Faker\Generator;
use App\Models\User;
use App\Models\Space;
use App\Models\Tag;
use App\Models\Earning;
use App\Models\Spending;
use App\Models\Recurring;
use App\Models\SpaceInvite;
use Illuminate\Support\Str;

$factory->define(User::class, function (Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10)
    ];
});

$factory->define(APIKey::class, function (Generator $faker) {
    return [
        'token' => Str::random(50)
    ];
});

$factory->define(Space::class, function (Generator $faker) {
    return [
        'currency_id' => $faker->numberBetween(1, 3),
        'name' => $faker->firstName . '\'s Space'
    ];
});

$factory->define(SpaceInvite::class, function (Generator $faker) {
    return [
        'space_id' => Space::all()->random()->id,
        'invitee_user_id' => User::all()->random()->id,
        'inviter_user_id' => User::all()->random()->id,
        'role' => 'regular'
    ];
});

$factory->define(Tag::class, function (Generator $faker) {
    return [
        'name' => ucfirst($faker->word)
    ];
});

$factory->define(Earning::class, function (Generator $faker) {
    return [
        'happened_on' => $faker->dateTimeBetween('-50 days', 'now')->format('Y-m-d'),
        'description' => implode(' ', array_map('ucfirst', $faker->words(3))),
        'amount' => $faker->randomNumber(3)
    ];
});

$factory->define(Spending::class, function (Generator $faker) {
    return [
        'happened_on' => $faker->dateTimeBetween('-50 days', 'now')->format('Y-m-d'),
        'description' => implode(' ', array_map('ucfirst', $faker->words(3))),
        'amount' => $faker->randomNumber(3)
    ];
});

$factory->define(Budget::class, function (Generator $faker) {
    return [
        'period' => 'monthly',
        'amount' => $faker->randomNumber(3)
    ];
});

$factory->define(Recurring::class, function (Generator $faker) {
    return [
        'type' => 'earning',
        'interval' => 'monthly',
        'day' => $faker->numberBetween(1, 28),
        'starts_on' => $faker->dateTimeBetween('-50 days', 'now')->format('Y-m-d'),
        'description' => implode(' ', array_map('ucfirst', $faker->words(3))),
        'amount' => $faker->randomNumber(3)
    ];
});

$factory->define(Currency::class, function (Generator $faker) {
    return [
        'name' => $faker->word(),
        'symbol' => $faker->word()
    ];
});

$factory->define(ConversionRate::class, function (Generator $faker) {
    return [
        'rate' => $faker->randomFloat(2, .5, 2)
    ];
});
