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
        Schema::create('guia_remision', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_emision');
            $table->string('numero');
            $table->string('destinatario_tipo_documento');
            $table->string('destinatario_razon_social');
            $table->string('motivo_traslado')->nullable();
            $table->enum('modalidad_traslado', ['01', 02])->nullable();
            $table->string('direccion_partida')->nullable();
            $table->string('ubigeo_partida')->nullable();
            $table->string('direccion_llegada')->nullable();
            $table->string('ubigeo_llegada')->nullable();
            $table->date('fecha_inicio_traslado')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('guia_remision');
    }
};
