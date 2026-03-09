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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();

            // Relaciones principales
            $table->unsignedBigInteger('work_order_type_id');
            $table->unsignedBigInteger('vehiculo_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('tecnico_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('empresa_id');

            // Fechas
            $table->dateTime('fecha_programada');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_finalizacion')->nullable();
            $table->dateTime('fecha_cerrado')->nullable();

            // Estado
            $table->enum('estado', ['pendiente', 'en_proceso', 'finalizado', 'cancelado'])->default('pendiente');

            // Observaciones
            $table->text('observaciones_inicial')->nullable();
            $table->text('observaciones_tecnico')->nullable();
            $table->text('observaciones_final')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->string('imei', 15)->nullable()->comment('IMEI del dispositivo GPS instalado (15 dígitos)');
            $table->string('iccid', 20)->nullable()->comment('ICCID de la tarjeta SIM (19-20 dígitos)');
            $table->string('modelo_dispositivo', 100)->nullable()->comment('Modelo del dispositivo GPS instalado');
            $table->string('ubicacion_dispositivo')->nullable()->comment('Ubicación física del dispositivo en el vehículo');
            $table->datetime('fecha_termino')->nullable()->comment('Fecha y hora real de terminación del trabajo');
            // Metadata - Guardar snapshot del tipo para preservar costos
            $table->json('tipo_data')->nullable(); // {nombre, costo_base, requiere_imei, etc}
            $table->json('metadata')->nullable();
            $table->boolean('bloqueado')->default(false); // No editable después de cerrar

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('work_order_type_id')->references('id')->on('work_order_types')->onDelete('restrict');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('restrict');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('restrict');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            // Índices
            $table->index('estado');
            $table->index('fecha_programada');
            $table->index(['empresa_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
