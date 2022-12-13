<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->text('data')->nullable();
            $table->date('fecha');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('reportes_id');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reportes_id')->references('id')->on('reportes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recordatorios');
    }
}
