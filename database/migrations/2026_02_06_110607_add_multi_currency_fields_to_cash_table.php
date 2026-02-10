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
        Schema::table('cash', function (Blueprint $table) {
            // Agregar saldos separados por moneda
            $table->decimal('saldo_inicial_pen', 15, 2)->default(0)->after('saldo_inicial');
            $table->decimal('saldo_inicial_usd', 15, 2)->default(0)->after('saldo_inicial_pen');
            $table->decimal('saldo_actual_pen', 15, 2)->default(0)->after('saldo_actual');
            $table->decimal('saldo_actual_usd', 15, 2)->default(0)->after('saldo_actual_pen');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash', function (Blueprint $table) {
            $table->dropColumn(['saldo_inicial_pen', 'saldo_inicial_usd', 'saldo_actual_pen', 'saldo_actual_usd']);
        });
    }
};
