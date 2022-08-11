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
            $table->date('payment_date');
            $table->text('nota')->nullable();
            $table->unsignedBigInteger('amount');
            $table->string('unique_hash')->nullable();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('facturas_id')->unsigned()->nullable();
            $table->foreign('facturas_id')->references('id')->on('facturas')->onDelete('cascade');
            $table->unsignedBigInteger('empresas_id')->unsigned()->nullable();
            $table->foreign('empresas_id')->references('id')->on('empresas')->onDelete('cascade');
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
