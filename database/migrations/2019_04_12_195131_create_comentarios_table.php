<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comentarios');
            $table->date('fecha');
            $table->boolean('inicial')->default(false);
            $table->boolean('ordenanza')->default(false);
            $table->boolean('veedor')->default(false);
            $table->boolean('problema')->default(false);            
            $table->integer('sin_apliccion')->default(0);         
            $table->integer('apliccion_controlada')->default(0);
            $table->unsignedInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('localidades');
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
        Schema::dropIfExists('comentarios');
    }
}
