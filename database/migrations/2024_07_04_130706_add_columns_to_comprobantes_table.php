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
        Schema::table('comprobantes', function (Blueprint $table) {
            $table->string('numero_cuotas')->nullable();
            $table->string('vence_cuotas')->nullable();
            $table->text('detalle_cuotas')->nullable();
            $table->enum('invoice_forma_pago', ["CONTADO", "CREDITO"])->default('CONTADO');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comprobantes', function (Blueprint $table) {
            //
        });
    }
};
