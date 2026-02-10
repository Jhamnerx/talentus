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
        Schema::table('detalles_cobros', function (Blueprint $table) {
            // Referencias a documentos creados
            $table->foreignId('venta_id')->nullable()->constrained('ventas')->onDelete('set null');
            $table->foreignId('recibo_id')->nullable()->constrained('recibos')->onDelete('set null');
            
            // Estado de facturación
            $table->enum('estado_facturacion', ['SIN_FACTURAR', 'FACTURADO', 'PAGADO'])
                ->default('SIN_FACTURAR');
            
            // Fechas de seguimiento
            $table->date('fecha_facturacion')->nullable();
            $table->date('fecha_pago')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropForeign(['venta_id']);
            $table->dropForeign(['recibo_id']);
            $table->dropColumn([
                'venta_id',
                'recibo_id',
                'estado_facturacion',
                'fecha_facturacion',
                'fecha_pago'
            ]);
        });
    }
};
