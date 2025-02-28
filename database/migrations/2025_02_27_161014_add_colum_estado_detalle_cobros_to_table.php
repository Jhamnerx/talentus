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
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->boolean('estado')->default(0)->after('fecha');
            $table->text('observacion')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
