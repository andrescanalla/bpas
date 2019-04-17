<?php

use Illuminate\Database\Seeder;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        factory(App\Localidad::class)->create([
            'nombre' => 'Zona Sur',
            'departamento_id' => 1,            
        ]);  
        factory(App\Localidad::class)->create([
            'nombre' => 'Casilda',
            'departamento_id' => 2,
            'municipio' => true
        ]);        
        factory(App\Localidad::class)->create([
            'nombre' => 'Arequito',
            'departamento_id' => 2,
            'municipio' => true
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Arteaga',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Berabevú',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Bigand',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Chabás',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Chañar Ladeado',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Gödeken',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Los Molinos',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Los Nogales',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Los Quirquinchos',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'San José de la Esquina',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Sanford',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Villada',
            'departamento_id' => 2
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Armstrong',
            'departamento_id' => 3,
            'municipalidad' => true
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Las Parejas',
            'departamento_id' => 3,
            'municipalidad' => true
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Las Rosas',
            'departamento_id' => 3,
            'municipalidad' => true
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Bouquet',
            'departamento_id' => 3
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Montes de Oca',
            'departamento_id' => 3
        ]);
        factory(App\Localidad::class)->create([
            'nombre' => 'Tortugas',
            'departamento_id' => 3
        ]);   







    }
}
