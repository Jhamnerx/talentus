<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('clientes_id');
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('divisa')->default('PEN');
            $table->string('tipo_pago');
            $table->enum('estado', ['BORRADOR', 'COMPLETADO'])->default('BORRADOR');
            $table->enum('pago_estado', ['UNPAID', 'PAID'])->default('UNPAID');
            $table->unsignedBigInteger('empresa_id');
            $table->boolean('enviado')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);

            $table->string('nota')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('descuento')->nullable();

            $table->unsignedBigInteger('presupuestos_id')->nullable();
            $table->unsignedBigInteger('user_id')->default(1);

            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('presupuestos_id')->references('id')->on('presupuestos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
