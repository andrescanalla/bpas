<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('calendar_id')->unique();
            $table->unsignedInteger('implementador_id');
            $table->foreign('implementador_id')->references('id')->on('implementadores');
            $table->unsignedInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('localidades');
            $table->unsignedInteger('tipo_visita_id');
            $table->foreign('tipo_visita_id')->references('id')->on('tipo_visitas');            
            $table->date('fecha');
            $table->text('comentarios')->nullable();
            $table->date('calendar_update')->nullable();
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
        Schema::dropIfExists('visitas');
    }
}
