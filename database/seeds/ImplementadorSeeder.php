<?php

use Illuminate\Database\Seeder;

class ImplementadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Implementador::class)->create([
            'nombre' => 'Equipo',
            'apellido' => 'Bpas',
            'departamento_id' => 1,            
        ]);
        factory(App\Implementador::class)->create([
            'nombre' => 'Leandro',
            'apellido' => 'Cruzeño',
            'departamento_id' => 2,            
        ]);
        factory(App\Implementador::class)->create([
            'nombre' => 'Ezequiel',
            'apellido' => 'Piola',
            'departamento_id' => 3,            
        ]);
        factory(App\Implementador::class)->create([
            'nombre' => 'Daniel',
            'apellido' => 'Calaon',
            'departamento_id' => 4,            
        ]);
        factory(App\Implementador::class)->create([
            'nombre' => 'Veronica',
            'apellido' => 'Reyes',
            'departamento_id' => 5,            
        ]);
        factory(App\Implementador::class)->create([
            'nombre' => 'Renata',
            'apellido' => 'Luna',
            'departamento_id' => 6,            
        ]); 
        factory(App\Implementador::class)->create([
            'nombre' => 'Daiana',
            'apellido' => 'Duran',
            'departamento_id' => 7,            
        ]); 
        factory(App\Implementador::class)->create([
            'nombre' => 'Pablo',
            'apellido' => 'Sclausero',
            'departamento_id' => 8,            
        ]);           
    }
}
