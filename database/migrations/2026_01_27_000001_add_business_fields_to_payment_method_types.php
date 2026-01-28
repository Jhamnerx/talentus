<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_method_types', function (Blueprint $table) {
            $table->boolean('has_card')->default(false)->after('description')->comment('Indica si requiere tarjeta de crédito/débito');
            $table->integer('number_days')->nullable()->after('has_card')->comment('Días de crédito');
            $table->decimal('charge', 12, 2)->nullable()->after('number_days')->comment('Comisión/recargo');
            $table->boolean('is_credit')->default(false)->after('charge')->comment('Define si es tipo crédito');
            $table->boolean('is_cash')->default(false)->after('is_credit')->comment('Define si es efectivo');
        });

        // Actualizar registros existentes según SUNAT IDs
        DB::table('payment_method_types')->where('id', '001')->update(['is_cash' => false]); // Depósito
        DB::table('payment_method_types')->where('id', '003')->update(['is_cash' => false]); // Transferencia
        DB::table('payment_method_types')->where('id', '005')->update(['has_card' => true]); // Tarjeta débito
        DB::table('payment_method_types')->where('id', '006')->update(['has_card' => true]); // Tarjeta crédito
        DB::table('payment_method_types')->where('id', '008')->update(['is_cash' => true]); // Efectivo sin obligación
        DB::table('payment_method_types')->where('id', '009')->update(['is_cash' => true]); // Efectivo
        DB::table('payment_method_types')->where('id', '012')->update(['has_card' => true]); // Tarjeta crédito no domiciliado
        DB::table('payment_method_types')->where('id', '013')->update(['has_card' => true]); // Tarjeta crédito exterior
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_method_types', function (Blueprint $table) {
            $table->dropColumn(['has_card', 'number_days', 'charge', 'is_credit', 'is_cash']);
        });
    }
};
