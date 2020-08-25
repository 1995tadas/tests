<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use App\Question;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => factory(Question::class),
        'number' => $faker->numberBetween(1, 8),
        'content' => $faker->text(255),
        'correct' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
});
