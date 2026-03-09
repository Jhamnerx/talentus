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
        Schema::table('ventas_detalles', function (Blueprint $table) {
            $table->text('descripcion_pdf')->nullable()->after('descripcion');
            $table->json('imeis')->nullable()->after('descripcion_pdf');
        });

        Schema::table('detalle_recibos', function (Blueprint $table) {
            $table->text('descripcion_pdf')->nullable()->after('descripcion');
            $table->json('imeis')->nullable()->after('descripcion_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas_detalles', function (Blueprint $table) {
            $table->dropColumn(['descripcion_pdf', 'imeis']);
        });

        Schema::table('detalle_recibos', function (Blueprint $table) {
            $table->dropColumn(['descripcion_pdf', 'imeis']);
        });
    }
};
