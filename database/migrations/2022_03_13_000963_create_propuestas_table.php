<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->string('numero');
            $table->date('fecha');
            $table->date('fecha_caducidad');
            $table->string('divisa')->default('PEN');
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('impuesto', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('subtotalSoles', 10, 2)->nullable();
            $table->decimal('impuestoSoles', 10, 2)->nullable();
            $table->decimal('totalSoles', 10, 2)->nullable();
            $table->decimal('tipoCambio', 10, 3)->nullable();
            $table->enum('estado', [0, 1, 2])->default(0);
            $table->string('nota')->nullable();
            $table->unsignedBigInteger('empresa_id')->unsigned()->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('presupuestos');
    }
}
