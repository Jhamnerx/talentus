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
            $table->string('token')->nullable();
            $table->unsignedBigInteger('vehiculos_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('numero')->nullable();
            $table->string('sim_card')->nullable();
            $table->string('nuevo_numero')->nullable();
            $table->string('nuevo_sim_card')->nullable();
            $table->string('dispositivo')->nullable();
            $table->string('modelo_velocimetro')->nullable();
            $table->boolean('leido')->default(false);
            $table->dateTime('fecha_hora');
            $table->boolean('respuesta')->default(false);
            $table->dateTime('fecha_validacion')->nullable();
            $table->boolean('sent_message')->default(false);
            $table->dateTime('fecha_termino')->nullable();
            $table->enum('estado', ['UNREAD', 'COMPLETE', 'PENDIENT', 'CANCELED'])->default('UNREAD');
            $table->unsignedBigInteger('tipo_tarea_id')->nullable();
            $table->text('imagen_url')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('set null');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('tipo_tarea_id')->references('id')->on('tipo_tareas')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
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
