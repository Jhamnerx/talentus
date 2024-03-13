<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dispositivos_users', function (Blueprint $table) {
            $table->unsignedBigInteger('tecnico_id')->nullable()->after('imei')->unsigned();

            $table->foreign('imei')->references('imei')->on('dispositivos');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispositivos_users', function (Blueprint $table) {
            //
        });
    }
};
