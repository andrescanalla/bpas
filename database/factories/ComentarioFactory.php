<?php

use Faker\Generator as Faker;

$factory->define(App\Comentario::class, function (Faker $faker) {
    return [
        'comentarios' => $faker->text,
        'localidad_id' => random_int(1, 2),        
    ];
});
