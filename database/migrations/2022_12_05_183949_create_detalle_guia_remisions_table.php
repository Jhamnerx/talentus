<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_guia_remision', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id')->unsigned()->nullable();
            $table->string('codigo');
            $table->decimal('cantidad', 15, 2);
            $table->string('unidad_medida');
            $table->string('descripcion');
            $table->unsignedBigInteger('guia_remision_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('guia_remision_id', 'fk_detalle_guia')->references('id')->on('guia_remision')->onDelete('cascade');
            $table->foreign('producto_id', 'fk_guia_d_producto')->references('id')->on('productos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_guia_remision');
    }
};
