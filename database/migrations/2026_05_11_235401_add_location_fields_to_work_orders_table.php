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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->decimal('ubicacion_lat',  10, 8)->nullable()->after('metadata');
            $table->decimal('ubicacion_lng',  11, 8)->nullable()->after('ubicacion_lat');
            $table->string('ubicacion_direccion', 500)->nullable()->after('ubicacion_lng');
            $table->decimal('tecnico_lat',    10, 8)->nullable()->after('ubicacion_direccion');
            $table->decimal('tecnico_lng',    11, 8)->nullable()->after('tecnico_lat');
            $table->timestamp('tecnico_last_seen')->nullable()->after('tecnico_lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'ubicacion_lat',
                'ubicacion_lng',
                'ubicacion_direccion',
                'tecnico_lat',
                'tecnico_lng',
                'tecnico_last_seen',
            ]);
        });
    }
};
