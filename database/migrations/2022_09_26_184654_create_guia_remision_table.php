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
            $table->string('serie_numero');
            $table->date('fecha_emision');
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('razon_social');
            $table->string('motivo_traslado')->nullable();
            $table->enum('modalidad_traslado', ['01', '02'])->nullable();
            $table->date('fecha_inicio_traslado')->nullable();
            $table->string('peso')->nullable();
            $table->string('cantidad_items')->nullable();
            $table->string('numero_contenedor')->nullable();
            $table->string('code_puerto')->nullable();
            $table->string('direccion_partida')->nullable();
            $table->string('ubigeo_partida')->nullable();
            $table->string('direccion_llegada')->nullable();
            $table->string('ubigeo_llegada')->nullable();

            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('factura_id')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('factura_id')->references('id')->on('facturas')->onDelete('set null');

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
        Schema::dropIfExists('guia_remision');
    }
};
