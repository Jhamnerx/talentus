<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('mantenimiento_id')
                ->nullable()
                ->after('cliente_id')
                ->comment('Notificación de mantenimiento programado vinculada a esta orden');

            $table->foreign('mantenimiento_id')
                ->references('id')
                ->on('mantenimientos')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['mantenimiento_id']);
            $table->dropColumn('mantenimiento_id');
        });
    }
};
