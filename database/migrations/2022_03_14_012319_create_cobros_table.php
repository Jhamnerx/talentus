<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id');
            $table->string('periodo');
            $table->decimal('monto_unidad', 10, 2);
            $table->integer('cantidad_unidades');
            $table->string('tipo_pago');
            $table->string('observacion')->nullable();
            $table->date('fecha');
            $table->enum('estado', [0, 1, 2])->default(0);

            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');

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
        Schema::dropIfExists('cobros');
    }
}
