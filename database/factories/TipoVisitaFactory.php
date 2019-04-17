<?php

use Faker\Generator as Faker;

$factory->define(App\TipoVisita::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
    ];
});
