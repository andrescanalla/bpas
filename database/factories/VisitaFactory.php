<?php

use Faker\Generator as Faker;

$factory->define(App\Visita::class, function (Faker $faker) {
    return [
        'implementador_id' => random_int(1, 2),
        'calendar_id' =>  $faker->md5,
        'localidad_id' => random_int(1, 2),
        'tipo_visita_id' => random_int(1, 2),
        'fecha' => $faker->date,
        'comentarios' => $faker->text,  
    ];
});
