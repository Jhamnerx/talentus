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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->string('cargo')->nullable();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('birthday')->nullable();
            $table->string('email')->nullable();
            $table->boolval('is_gerente')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('descripcion')->nullable();
            $table->text('nota')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
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
        Schema::dropIfExists('contacto_flotas');
    }
}
