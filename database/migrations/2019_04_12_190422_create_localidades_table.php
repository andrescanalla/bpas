<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->unsignedInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('departamentos');
            $table->boolean('municipio')->default(false);
            $table->boolean('presentacion')->default(false);
            $table->boolean('entrevista')->default(false);
            $table->boolean('informe')->default(false);
            $table->decimal('lng',8,6);
            $table->decimal('lat',8,6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
