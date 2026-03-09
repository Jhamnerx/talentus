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
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('gpswox_id')->nullable()->after('id')->comment('ID del dispositivo en GPSWox');
            $table->index('gpswox_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropIndex(['gpswox_id']);
            $table->dropColumn('gpswox_id');
        });
    }
};
