<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

$factory->define(Task::class, function (Faker $faker) {
    return [
        "title" => Str::random(10),
        "description" => Str::random(10),
        "status" => Arr::random([0,1])
    ];
});
