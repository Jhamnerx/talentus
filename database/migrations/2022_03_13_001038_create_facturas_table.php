<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras_factura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedores_id')->nullable();
            $table->string('numero');
            $table->date('fecha');
            $table->date('fecha_vencimiento');
            $table->decimal('total', 10, 2);
            $table->boolean('eliminado')->default(false);
            $table->unsignedBigInteger('empresa_id');
            $table->string('nota');

            $table->foreign('proveedores_id')->references('id')->on('proveedores')->onDelete('set null');





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
        Schema::dropIfExists('compras_factura');
    }
}
