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
        Schema::create('cash', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('saldo_inicial', 12, 2)->default(0);
            $table->decimal('saldo_actual', 12, 2)->default(0);
            $table->string('moneda', 3)->default('PEN');
            $table->date('fecha_apertura');
            $table->date('fecha_cierre')->nullable();
            $table->boolean('estado')->default(1); // 1 = Abierta, 0 = Cerrada
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash');
    }
};
