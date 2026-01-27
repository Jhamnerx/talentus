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
        Schema::create('accounts_receivable', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->unsignedBigInteger('recibo_id')->nullable();
            $table->unsignedBigInteger('cobro_id')->nullable();
            $table->string('tipo_documento'); // FACTURA, BOLETA, RECIBO
            $table->string('numero_documento');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->decimal('monto_total', 12, 2);
            $table->decimal('monto_pagado', 12, 2)->default(0);
            $table->decimal('saldo_pendiente', 12, 2);
            $table->string('moneda', 3)->default('PEN');
            $table->string('estado')->default('PENDIENTE'); // PENDIENTE, PAGADO, VENCIDO, PARCIAL (PaymentStatus enum)
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('recibo_id')->references('id')->on('recibos');
            $table->foreign('cobro_id')->references('id')->on('cobros');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->index(['estado', 'fecha_vencimiento']);
            $table->index(['cliente_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts_receivable');
    }
};
