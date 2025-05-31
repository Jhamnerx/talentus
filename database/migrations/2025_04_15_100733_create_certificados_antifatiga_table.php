<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificados_antifatiga', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_emision')->nullable();
            $table->date('inicio_cobertura')->nullable();
            $table->date('fin_cobertura')->nullable();
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->json('cliente')->nullable();
            $table->boolean('sello')->default(1);
            $table->boolean('fondo')->default(1);
            $table->date('fecha_instalacion')->nullable();
            $table->text('hash')->nullable();
            $table->unsignedBigInteger('ciudades_id')->nullable();
            $table->unsignedBigInteger('dispositivo_id')->nullable();
            $table->string('imei_personalizado')->nullable();
            $table->boolean('cambiar_imei')->default(false);

            $table->foreign('ciudades_id')->references('id')->on('ciudades')->onDelete('set null');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados_antifatiga');
    }
};
