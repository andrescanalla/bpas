<?php

use Faker\Generator as Faker;

$factory->define(App\Implementador::class, function (Faker $faker) {
    return [     
      'nombre' => $faker->firstName,
      'apellido' => $faker->lastName,
      'departamento_id' => random_int(1, 2),
      'email' => $faker->email,
      'telefono' => $faker->phoneNumber,    
    ];
});
