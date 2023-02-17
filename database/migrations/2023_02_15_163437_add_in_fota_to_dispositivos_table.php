<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispositivos', function (Blueprint $table) {
            //
            $table->boolean('in_fota')->default(false)->after('estado');
            $table->boolean('consultado')->default(false)->after('in_fota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fota_to_dispositivos', function (Blueprint $table) {
            //
        });
    }
};
