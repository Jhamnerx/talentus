<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reportes_id');
            $table->string('detalle');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('reportes_id')->references('id')->on('reportes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_reportes');
    }
}
