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
        Schema::create('notificaciones_cobro', function (Blueprint $table) {
            $table->id();

            // Relaciones principales
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('detalle_cobro_id')->constrained('detalles_cobros')->onDelete('cascade');
            $table->foreignId('cobro_id')->constrained('cobros')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->nullable()->constrained('vehiculos')->onDelete('set null');

            // Información del cobro
            $table->date('fecha_vencimiento')->comment('Fecha en que debe facturarse');
            $table->decimal('monto', 10, 2)->comment('Monto a cobrar');
            $table->string('moneda', 3)->default('PEN')->comment('PEN o USD');
            $table->text('descripcion')->nullable()->comment('Descripción del servicio');

            // Estado del documento
            $table->enum('estado', ['PENDIENTE', 'FACTURADO', 'PAGADO', 'CANCELADO'])->default('PENDIENTE');

            // Referencias a documentos generados
            $table->foreignId('venta_id')->nullable()->constrained('ventas')->onDelete('set null');
            $table->foreignId('recibo_id')->nullable()->constrained('recibos')->onDelete('set null');

            // Fechas de seguimiento
            $table->timestamp('fecha_facturacion')->nullable()->comment('Cuándo se generó Venta/Recibo');
            $table->timestamp('fecha_pago')->nullable()->comment('Cuándo se recibió el pago');

            // Observaciones
            $table->text('observaciones')->nullable();

            // Soft deletes y timestamps
            $table->softDeletes();
            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index(['empresa_id', 'estado']);
            $table->index(['fecha_vencimiento', 'estado']);
            $table->index('detalle_cobro_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones_cobro');
    }
};
