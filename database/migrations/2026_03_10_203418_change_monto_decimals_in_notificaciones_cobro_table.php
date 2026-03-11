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
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            $table->decimal('monto', 15, 4)->comment('Monto a cobrar')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            $table->decimal('monto', 10, 2)->comment('Monto a cobrar')->change();
        });
    }
};
