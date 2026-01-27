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
        Schema::create('accounts_payable', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->unsignedBigInteger('proveedor_id');
            $table->string('tipo_documento'); // FACTURA, BOLETA, OTROS
            $table->string('numero_documento');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->decimal('monto_total', 12, 2);
            $table->decimal('monto_pagado', 12, 2)->default(0);
            $table->decimal('saldo_pendiente', 12, 2);
            $table->string('moneda', 3)->default('PEN');
            $table->string('estado')->default('PENDIENTE'); // PENDIENTE, PAGADO, VENCIDO, PARCIAL (PaymentStatus enum)
            $table->string('concepto')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->index(['estado', 'fecha_vencimiento']);
            $table->index(['proveedor_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_payable');
    }
};
