<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facturas_id');

            $table->string('descripcion');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('impuesto', 10, 2);
            $table->decimal('importe', 10, 2);


            $table->foreign('facturas_id')->references('id')->on('compras_factura')->onDelete('cascade');






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
        Schema::dropIfExists('detalle_facturas');
    }
}
