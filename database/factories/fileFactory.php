<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'link' => $faker->url,
        'size' => random_int(50, 20000),
        'type' => $faker->word(3),
        'fileable_type' => 'person',
        'fileable_id' => 1,
    ];
});
