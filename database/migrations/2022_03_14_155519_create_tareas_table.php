<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculos_id')->nullable();
            $table->string('numero');
            $table->string('sim_card');
            $table->string('nuevo_numero');
            $table->string('nuevo_sim');
            $table->string('dispositivo');
            $table->boolean('leido');
            $table->dateTime('fecha_hora');
            $table->boolean('respuesta');
            $table->unsignedBigInteger('tipo_tarea')->nullable();

            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('set null');
            $table->foreign('tipo_tarea')->references('id')->on('tipo_tareas')->onDelete('set null');

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
        Schema::dropIfExists('tareas');
    }
}
