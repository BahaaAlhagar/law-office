<?php

use Faker\Generator as Faker;

$factory->define(App\Person::class, function (Faker $faker) {
    return [
        'name' 		=> $faker->unique()->name,
        'location' 	=> $faker->address,
        'idenity' 	=> $faker->ean13,
        'phone' 	=> $faker->PhoneNumber,
        'is_client' => $faker->boolean,
    ];
});
