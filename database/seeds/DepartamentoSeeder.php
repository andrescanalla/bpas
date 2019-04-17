<?php

use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Departamento::class)->create([
                'nombre' => 'Todos - Zona Sur',
                'cantidad_localidades' =>120]);
        factory(App\Departamento::class)->create([
             'nombre' => 'Caseros',
             'cantidad_localidades' =>14]);
        factory(App\Departamento::class)->create([
                'nombre' => 'Belgrano',
                'cantidad_localidades' =>6]);  
        factory(App\Departamento::class)->create([
                'nombre' => 'Iriondo',
                'cantidad_localidades' =>12]);
        factory(App\Departamento::class)->create([
            'nombre' => 'San Lorenzo',
            'cantidad_localidades' =>15]);
        factory(App\Departamento::class)->create([
                'nombre' => 'Rosario',
                'cantidad_localidades' =>24]);  
        factory(App\Departamento::class)->create([
                'nombre' => 'General Lopez',
                'cantidad_localidades' =>31]);
        factory(App\Departamento::class)->create([
                'nombre' => 'Constitucion',
                'cantidad_localidades' =>19]);      
    }
}
