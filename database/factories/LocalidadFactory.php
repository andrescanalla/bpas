<?php

use Faker\Generator as Faker;

$factory->define(App\Localidad::class, function (Faker $faker) {
    return [
      'nombre'=>$faker->city,
      'departamento_id'=>random_int(1, 2),  
    ];
});
