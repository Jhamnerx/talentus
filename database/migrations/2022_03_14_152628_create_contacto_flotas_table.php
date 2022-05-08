<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactoFlotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_flotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flotas_id');
            $table->string('cargo')->nullable();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->unsignedBigInteger('empresa_id');
            $table->string('descripcion')->nullable();

            $table->foreign('flotas_id')->references('id')->on('flotas')->onDelete('cascade');

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
        Schema::dropIfExists('contacto_flotas');
    }
}
