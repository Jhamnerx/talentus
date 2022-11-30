<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_recibos', function (Blueprint $table) {
            $table->id();

            $table->string('producto');
            $table->string('descripcion')->nullable();
            $table->string('descuento_type')->nullable();
            $table->decimal('descuento', 15, 2)->nullable();
            $table->decimal('descuento_val', 15, 2)->unsigned()->nullable();
            $table->decimal('cantidad', 15, 2);
            $table->decimal('precio', 15, 2);
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('recibos_id')->nullable();
            $table->unsignedBigInteger('producto_id')->unsigned()->nullable();
            $table->unsignedBigInteger('empresa_id')->unsigned()->nullable();


            $table->foreign('recibos_id')->references('id')->on('recibos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_recibos');
    }
}
