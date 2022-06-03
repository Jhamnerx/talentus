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
            $table->unsignedBigInteger('clientes_id');
            $table->string('numero');
            $table->string('tipo_pago');

            $table->date('fecha');
            $table->string('divisa')->default('PEN');
            $table->decimal('total', 10, 2);
            $table->date('fecha_pago');

            $table->enum('estado', [0, 1])->default(0);
            $table->string('nota')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('presupuestos_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);

            $table->foreign('presupuestos_id')->references('id')->on('presupuestos')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
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
        Schema::dropIfExists('recibos');
    }
}
