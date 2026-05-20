<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hacer vehiculo_id y cliente_id nullable en work_orders (para órdenes de proyecto)
        Schema::table('work_orders', function (Blueprint $table) {
            $table->boolean('es_proyecto')->default(false)->after('estado');
            $table->string('titulo_proyecto', 255)->nullable()->after('es_proyecto')
                ->comment('Título del proyecto cuando es_proyecto = true');
        });

        Schema::create('work_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('placa', 20);
            $table->string('cliente_nombre', 255)->nullable();
            // Tipo de trabajo para este ítem: instalacion/mantenimiento/cambio_chip/retiro/otro
            $table->string('tipo_trabajo', 50)->default('mantenimiento');
            $table->string('notas', 255)->nullable()->comment('Notas inline, ej: cambio de chip');
            // Estado del ítem
            $table->string('estado', 20)->default('pendiente')
                ->comment('pendiente / completado / omitido');
            // Datos capturados al completar
            $table->string('imei', 20)->nullable();
            $table->string('numero_sim', 30)->nullable();
            $table->text('observaciones')->nullable();
            // Orden de visualización
            $table->unsignedSmallInteger('orden')->default(0);
            $table->timestamps();

            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_order_items');

        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['es_proyecto', 'titulo_proyecto']);
        });
    }
};
