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
        Schema::create('anticipos_ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('descripcion')->nullable(); //DESCRIPCION
            $table->string('serie_correlativo_ref')->nullable(); //SERIE Y CORRELATIVO DE REFERENCIA
            $table->string('tipo_comprobante_ref')->nullable(); //TIPO DE COMPROBANTE DE REFERENCIA
            $table->decimal('valor_venta_ref', 12, 4)->nullable(); //TOTAL DE REFERENCIA
            $table->decimal('igv', 12, 4)->nullable(); //TOTAL DE REFERENCIA
            $table->decimal('total_invoice_ref', 12, 4)->nullable(); //TOTAL DE REFERENCIA
            //PAGO ANTICIPADO
            $table->string('codigo_anticipo')->nullable(); //CODIGO DE ANTICIPO
            $table->decimal('factor_anticipo', 12, 2)->nullable(); //MONTO DE ANTICIPO
            $table->dateTime('fecha_emision_ref')->nullable(); //FECHA DE ANTICIPO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anticipos_ventas');
    }
};
