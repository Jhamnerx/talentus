<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lineas', function (Blueprint $table) {
            $table->boolean('baja')->default(false)->after('date_to_suspend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lineas', function (Blueprint $table) {
            //
        });
    }
};
