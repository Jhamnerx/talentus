<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->foreign('to_user_id')->references('id')->on('users');
             $table->morphs('messageable');
             $table->string('action');
            $table->string('asunto', 30);
            $table->text('body');
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
        Schema::dropIfExists('mensajes');
    }
}
