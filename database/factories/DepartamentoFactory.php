<?php

use Faker\Generator as Faker;

$factory->define(App\Departamento::class, function (Faker $faker) {
    return [
        'nombre' => $faker->state,
        'cantidad_localidades' => $faker->numberBetween($min = 6, $max = 36),  
    ];
});
