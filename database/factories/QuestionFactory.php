<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Test;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'content' => $faker->text(255),
        'test_id' => factory(Test::class)
    ];
});
