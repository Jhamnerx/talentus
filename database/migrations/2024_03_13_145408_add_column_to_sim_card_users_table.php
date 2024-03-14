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
        Schema::table('sim_card_users', function (Blueprint $table) {

            $table->unsignedBigInteger('tecnico_id')->nullable()->after('sim_card')->unsigned();

            $table->foreign('sim_card')->references('sim_card')->on('sim_card');
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sim_card_users', function (Blueprint $table) {
            //
        });
    }
};
