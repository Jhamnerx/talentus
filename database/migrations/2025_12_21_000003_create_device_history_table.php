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
        Schema::create('device_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('vehiculo_id');

            // IMEI
            $table->unsignedBigInteger('dispositivo_id')->nullable();
            $table->string('imei')->nullable();
            $table->enum('accion_imei', ['instalado', 'retirado', 'reemplazado', 'ninguna'])->default('ninguna');

            // SIM
            $table->unsignedBigInteger('sim_card_id')->nullable();
            $table->string('iccid')->nullable();
            $table->string('numero_linea')->nullable();
            $table->enum('accion_sim', ['instalado', 'retirado', 'reemplazado', 'ninguna'])->default('ninguna');

            // Fechas
            $table->dateTime('fecha_instalacion')->nullable();
            $table->dateTime('fecha_retiro')->nullable();

            // Dispositivos anteriores (para reemplazos)
            $table->unsignedBigInteger('dispositivo_anterior_id')->nullable();
            $table->string('imei_anterior')->nullable();
            $table->unsignedBigInteger('sim_card_anterior_id')->nullable();
            $table->string('iccid_anterior')->nullable();

            // Metadata
            $table->text('observaciones')->nullable();
            $table->json('metadata')->nullable();

            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('restrict');
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos')->onDelete('set null');
            $table->foreign('sim_card_id')->references('id')->on('sim_card')->onDelete('set null');
            $table->foreign('dispositivo_anterior_id')->references('id')->on('dispositivos')->onDelete('set null');
            $table->foreign('sim_card_anterior_id')->references('id')->on('sim_card')->onDelete('set null');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            // Índices
            $table->index('vehiculo_id');
            $table->index('fecha_instalacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_history');
    }
};
