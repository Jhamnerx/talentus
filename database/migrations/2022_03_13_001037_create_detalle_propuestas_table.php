<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePropuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('producto');
            $table->string('descripcion')->nullable();
            $table->string('descuento_type')->nullable();
            $table->decimal('cantidad', 15, 2);
            $table->decimal('precio', 15, 2);
            $table->decimal('descuento', 15, 2)->nullable();
            $table->decimal('descuento_val', 15, 2)->nullable();
            $table->decimal('igv', 15, 2)->nullable();
            $table->decimal('total', 15, 2);
            $table->unsignedBigInteger('presupuestos_id')->nullable();
            $table->unsignedBigInteger('producto_id')->unsigned()->nullable();
            $table->unsignedBigInteger('empresa_id')->unsigned()->nullable();

            $table->foreign('presupuestos_id')->references('id')->on('presupuestos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
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
        Schema::dropIfExists('detalle_presupuestos');
    }
}
