<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Test;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Test::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'url' => Str::random(7),
        'user_id' => User::all()->random()->id,
    ];
});
