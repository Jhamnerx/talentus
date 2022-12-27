<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_solicitud');
            $table->string('nombre')->nullable();
            $table->string('email')->nullable();
            $table->string('detalle')->nullable();
            $table->string('servicio_solicitado')->nullable();
            $table->string('placa')->nullable();
            $table->string('fecha_inicial')->nullable();
            $table->string('fecha_final')->nullable();
            $table->string('telefono_envio')->nullable();
            $table->string('email_envio')->nullable();

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
        Schema::dropIfExists('solicitudes');
    }
};
