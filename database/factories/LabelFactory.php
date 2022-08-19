<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Label::class, function (Faker $faker) {
    return [
        "name" => Str::random(10),
    ];
});
