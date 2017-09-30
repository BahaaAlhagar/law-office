<?php

use Faker\Generator as Faker;

$factory->define(App\Contract::class, function (Faker $faker) {
    return [
        'number' => random_int(1, 50000),
        'year' => $faker->year,
        'type' 	=> random_int(1, 3),
        'letter' => $faker->randomLetter,
        'office' => $faker->city,
        'archive_number' => random_int(1, 100)
    ];
});
