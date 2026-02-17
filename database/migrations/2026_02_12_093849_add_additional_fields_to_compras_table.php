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
        Schema::table('compras', function (Blueprint $table) {
            // Fecha de vencimiento para compras a crédito
            $table->date('fecha_vencimiento')->nullable()->after('fecha_emision');

            // Sistema de cuotas para crédito
            $table->integer('numero_cuotas')->default(0)->after('forma_pago');
            $table->json('cuotas')->nullable()->after('numero_cuotas')->comment('Detalle de cuotas para pago a crédito');

            // Percepciones
            $table->decimal('total_percepcion', 12, 2)->nullable()->after('total')->comment('Total de percepción aplicada');
            $table->json('percepcion')->nullable()->after('total_percepcion')->comment('Detalle de percepción');

            // Observaciones más detalladas (mantener comentario para compatibilidad)
            $table->text('observacion')->nullable()->after('comentario')->comment('Observación detallada de la compra');

            // Guías asociadas (si la compra viene con guía de remisión)
            $table->json('guias')->nullable()->after('observacion')->comment('Guías de remisión asociadas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn([
                'fecha_vencimiento',
                'numero_cuotas',
                'cuotas',
                'total_percepcion',
                'percepcion',
                'observacion',
                'guias',
            ]);
        });
    }
};
