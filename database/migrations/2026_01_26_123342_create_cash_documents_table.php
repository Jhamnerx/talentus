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
        Schema::create('cash_documents', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante'); // INGRESOS FINANCIEROS, INGRESOS VARIOS, etc
            $table->string('numero')->unique();
            $table->date('fecha_emision');
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_documento')->nullable();
            $table->string('metodo_ingreso'); // Efectivo, Transferencia, etc
            $table->string('destino'); // CAJA GENERAL, Banco, etc
            $table->string('referencia')->nullable();
            $table->string('motivo');
            $table->decimal('monto', 12, 2);
            $table->string('moneda', 3)->default('PEN');
            $table->decimal('tipo_cambio', 8, 4)->default(1);
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('COMPLETADO'); // COMPLETADO, ANULADO
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->index(['fecha_emision', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_documents');
    }
};
