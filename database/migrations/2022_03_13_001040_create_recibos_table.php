<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('serie')->nullable();
            $table->string('numero')->nullable();
            $table->string('serie_numero')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_pago')->nullable();
            //$table->string('tipo_pago');
            $table->string('divisa')->default('PEN');
            //$table->string('tipo_pago');
            $table->enum('estado', ['BORRADOR', 'COMPLETADO'])->default('BORRADOR');
            $table->enum('pago_estado', ['UNPAID', 'PAID'])->default('UNPAID');


            $table->unsignedBigInteger('forma_pago')->nullable();

            $table->decimal('total', 10, 2);
            $table->enum('tipo_venta', ['CONTADO', 'CREDITO'])->default('CONTADO');
            $table->string('nota')->nullable();
            $table->boolean('sent')->default(false);
            $table->boolean('viewed')->default(false);
            $table->string('unique_hash')->nullable();


            $table->unsignedBigInteger('presupuestos_id')->nullable();
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('set null');
            $table->foreign('presupuestos_id')->references('id')->on('presupuestos')->onDelete('set null');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('forma_pago')->references('id')->on('payment_methods')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibos');
    }
}
