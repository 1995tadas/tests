<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use App\Solution;
use App\SolutionAnswer;
use Faker\Generator as Faker;

$factory->define(SolutionAnswer::class, function (Faker $faker) {
    return [
        'solution_id' => factory(Solution::class),
        'question_id' => factory(Question::class),
        'answer_number' => $faker->numberBetween(1, 8)
    ];
});
