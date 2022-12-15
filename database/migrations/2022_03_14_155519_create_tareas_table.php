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
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('numero')->nullable();
            $table->string('sim_card')->nullable();
            $table->string('nuevo_numero')->nullable();
            $table->string('nuevo_sim_card')->nullable();
            $table->string('dispositivo')->nullable();
            $table->boolean('leido')->default(false);
            $table->dateTime('fecha_hora');
            $table->boolean('respuesta');
            $table->enum('estado', ['UNREAD', 'COMPLETE', 'PENDIENT', 'CANCELED'])->default('UNREAD');
            $table->unsignedBigInteger('tipo_tarea')->nullable();
            $table->text('imagen_url')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('set null');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('tipo_tarea')->references('id')->on('tipo_tareas')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
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
