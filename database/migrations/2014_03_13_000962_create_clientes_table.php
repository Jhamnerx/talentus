<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social');
            $table->string('numero_documento', 30);
            $table->string('telefono', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('web_site')->nullable();
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('eliminado')->default(false);
            
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
        Schema::dropIfExists('clientes');
    }
}
