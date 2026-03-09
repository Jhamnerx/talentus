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
        Schema::create('work_order_signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');

            // Tipo de firma
            $table->enum('tipo', ['recepcion', 'conformidad']); // Inicio o cierre de OT

            // Archivo de firma (PNG)
            $table->string('filename');
            $table->string('path');
            $table->string('disk')->default('private');

            // Datos del firmante
            $table->string('nombre_firmante');
            $table->string('tipo_firmante'); // cliente, conductor, encargado, supervisor
            $table->string('documento_firmante')->nullable(); // DNI, RUC

            // Metadata de seguridad
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Timestamp de firma
            $table->dateTime('firmado_at');
            $table->unsignedBigInteger('tecnico_id'); // Técnico presente

            // Hash de validación
            $table->string('hash')->nullable(); // SHA256 del archivo para integridad

            $table->timestamps();

            // Foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('restrict');

            // Índices
            $table->index('work_order_id');
            $table->index('tipo');
            $table->unique(['work_order_id', 'tipo']); // Solo una firma por tipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_signatures');
    }
};
