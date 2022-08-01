<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->string('descripcion')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('set null');

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
        Schema::dropIfExists('flotas');
    }
}
