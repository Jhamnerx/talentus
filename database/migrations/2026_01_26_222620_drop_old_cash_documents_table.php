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
        Schema::dropIfExists('cash_documents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('cash_documents', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante');
            $table->string('numero')->unique();
            $table->date('fecha_emision')->index();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_documento')->nullable();
            $table->string('metodo_ingreso');
            $table->string('destino');
            $table->string('referencia')->nullable();
            $table->string('motivo');
            $table->decimal('monto', 12, 2);
            $table->string('moneda', 3)->default('PEN');
            $table->decimal('tipo_cambio', 8, 4)->default(1.0000);
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('COMPLETADO');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }
};
