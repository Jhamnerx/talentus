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
            $table->string('periodo')->default('MENSUAL')->after('plan'); // MENSUAL, BIMENSUAL, TRIMESTRAL, SEMESTRAL, ANUAL
            $table->date('fecha_inicio')->nullable()->after('periodo');
            $table->date('fecha_vencimiento')->nullable()->after('fecha_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropColumn(['periodo', 'fecha_inicio', 'fecha_vencimiento']);
        });
    }
};
