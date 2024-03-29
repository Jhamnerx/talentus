<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clientes_id');
            $table->unsignedBigInteger('vehiculos_id');
            $table->unsignedBigInteger('contratos_id')->nullable();
            $table->text('comentario')->nullable();
            $table->string('periodo');
            $table->string('divisa');
            $table->decimal('monto_unidad', 10, 2);
            $table->integer('cantidad_unidades')->nullable();
            $table->string('tipo_pago');
            $table->string('nota')->nullable();
            $table->string('observacion')->nullable();
            $table->date('fecha_vencimiento');
            $table->enum('estado', [0, 1, 2])->default(0);
            $table->boolean('suspendido')->default(false);
            $table->unsignedBigInteger('empresa_id')->nullable();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('vehiculos_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('contratos_id')->references('id')->on('contratos')->onDelete('cascade');

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
        Schema::dropIfExists('cobros');
    }
}
