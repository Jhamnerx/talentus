<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->boolean('gpswox_active')->nullable()->after('gpswox_id')
                ->comment('Estado activo/inactivo del dispositivo en GPSWox');
            $table->timestamp('gpswox_sincronizado_at')->nullable()->after('gpswox_active')
                ->comment('Última sincronización con la plataforma GPSWox');
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn(['gpswox_active', 'gpswox_sincronizado_at']);
        });
    }
};
