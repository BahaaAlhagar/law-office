<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'notes' => $faker->sentence,
        'date' => $faker->date,
        'completed' => $faker->boolean
    ];
});
