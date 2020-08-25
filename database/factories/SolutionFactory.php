<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Solution;
use App\User;
use App\Test;
use Faker\Generator as Faker;

$factory->define(Solution::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'test_id' => factory(Test::class),
        'show' => $faker->boolean,
    ];
});
