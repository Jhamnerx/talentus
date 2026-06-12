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
        Schema::table('tickets', function (Blueprint $table) {
            // El reloj SLA arranca desde aquí si está en el futuro, en lugar de created_at
            $table->timestamp('scheduled_at')->nullable()->after('due_at');
            // Deadline de restauración (TS remoto). Nivel 1→2 escala cuando se supera.
            $table->timestamp('ts_at')->nullable()->after('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'ts_at']);
        });
    }
};
