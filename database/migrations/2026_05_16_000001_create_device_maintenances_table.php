<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('device_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');
            // Relación opcional con vehículos locales (puede no estar sincronizado)
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('set null');
            // ID del dispositivo en el sistema de tracking (IMEI o device.id)
            $table->string('tracking_device_id', 100)->nullable();
            $table->string('tracking_device_name', 255)->nullable();
            $table->enum('tipo', ['mantenimiento', 'suspension', 'reactivacion'])->default('mantenimiento');
            $table->date('fecha');
            $table->string('motivo', 500)->nullable();
            $table->text('notas')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // Fuente: 'manual' (creado desde talentus) o 'tracking' (recibido del sistema GPS)
            $table->enum('source', ['manual', 'tracking'])->default('manual');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['empresa_id', 'tipo', 'fecha']);
            $table->index(['empresa_id', 'vehiculo_id']);
            $table->index('tracking_device_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_maintenances');
    }
};
