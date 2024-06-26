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
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->text('qr')->nullable();
            $table->text('ticket')->nullable();
            $table->text('nombre_cdr')->nullable()->after('nombre_xml');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->dropColumn('qr');
        });
    }
};
