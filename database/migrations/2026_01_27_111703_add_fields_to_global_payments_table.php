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
        Schema::table('global_payments', function (Blueprint $table) {
            $table->string('type_movement', 20)->after('id')->nullable()->comment('INGRESO o EGRESO');
            $table->date('date')->after('type_movement')->nullable()->comment('Fecha del pago');
            $table->text('description')->after('date')->nullable()->comment('Descripción del movimiento');
        });
    }

    /**
     * Reverse the migrations.     */
    public function down(): void
    {
        Schema::table('global_payments', function (Blueprint $table) {
            $table->dropColumn(['type_movement', 'date', 'description']);
        });
    }
};
