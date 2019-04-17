<?php

use Illuminate\Database\Seeder;

class TipoVisitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TipoVisita::class)->create([
            'nombre' => 'Presentacion Programa'           
        ]);  
        factory(App\TipoVisita::class)->create([
            'nombre' => 'Entrevista'           
        ]);
        factory(App\TipoVisita::class)->create([
            'nombre' => 'Presentacion y Entrevista'           
        ]); 
        factory(App\TipoVisita::class)->create([
            'nombre' => 'Informe'           
        ]);
        factory(App\TipoVisita::class)->create([
            'nombre' => 'Otro'           
        ]);        
    }
}
