<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero');
            $table->string('numero_operacion');
            $table->date('fecha');
            $table->text('nota')->nullable();
            $table->unsignedBigInteger('monto');
            $table->morphs('paymentable');
            $table->string('unique_hash')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('facturas_id')->unsigned()->nullable();
            //$table->foreign('facturas_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->unsignedBigInteger('empresa_id')->unsigned()->nullable();
            $table->unsignedBigInteger('cobros_id')->unsigned()->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('cobros_id')->references('id')->on('cobros')->onDelete('cascade');
            $table->unsignedBigInteger('payment_method_id')->unsigned()->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}
