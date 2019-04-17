<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->truncateTable([
            'tipo_visitas',
            'departamentos',
            'localidades',
            'implementadores',
            'visitas',
            'comentarios',
        ]);
        $this->call(TipoVisitaSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(LocalidadSeeder::class);
        $this->call(ImplementadorSeeder::class);
        $this->call(VisitaSeeder::class);
        $this->call(ComentarioSeeder::class);

    }

    protected function truncateTable(array $tables){

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    }
}
