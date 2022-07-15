<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cobros_id')->nullable();
            $table->string('tipo_pago');
            $table->decimal('monto', 10, 2);
            $table->string('descripcion')->nullable();

            $table->foreign('cobros_id')->references('id')->on('cobros')->onDelete('set null');

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
        Schema::dropIfExists('registro_cobros');
    }
}
