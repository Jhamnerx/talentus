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
            $table->unsignedBigInteger('recibos_id')->nullable();
            $table->string('producto');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('importe', 10, 2);

            $table->foreign('recibos_id')->references('id')->on('recibos')->onDelete('set null');


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
