<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'location' => $faker->city,
        'date' => $faker->date,
        'completed' => $faker->boolean
    ];
});
