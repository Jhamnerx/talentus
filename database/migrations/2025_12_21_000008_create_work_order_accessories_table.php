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
        Schema::create('work_order_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_order_id');
            $table->unsignedBigInteger('producto_id')->nullable(); // Relación con productos

            // Detalles del accesorio
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad')->default(1);
            $table->string('serial')->nullable();
            $table->enum('accion', ['instalado', 'retirado', 'reemplazado'])->default('instalado');

            // Precios
            $table->decimal('precio_unitario', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);

            $table->timestamps();

            // Foreign keys
            $table->foreign('work_order_id')->references('id')->on('work_orders')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');

            // Índices
            $table->index('work_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_accessories');
    }
};
