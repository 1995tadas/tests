<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use App\User;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    $languageCodes = ['lt', 'en'];
    return [
        'user_id' => factory(User::class),
        'language' => $languageCodes[array_rand($languageCodes)],
        'test_attempts' => 1,
        'default_questions' => 4
    ];
});
