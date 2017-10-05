<?php

use Faker\Generator as Faker;

$factory->define(App\Issue::class, function (Faker $faker) {
    return [
		'type' => random_int(1, 12),
		'number' => random_int(1, 60000),
		'year' => $faker->year,
		'adv_number' => random_int(1, 60000),
		'adv_year' => $faker->year,
		'court' => $faker->city,
		'room' => random_int(1, 20),
		'subject' => $faker->sentence
    ];
});
