<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->enum('origen', ['manual', 'auto'])->default('manual')->after('estado');
            $table->foreignId('atendido_por')->nullable()->constrained('users')->nullOnDelete()->after('origen');
            $table->timestamp('atendido_at')->nullable()->after('atendido_por');
            $table->timestamp('cerrado_at')->nullable()->after('atendido_at');
            $table->decimal('horas_sin_transmision', 8, 2)->nullable()->after('cerrado_at');
        });
    }

    public function down(): void
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropForeign(['atendido_por']);
            $table->dropColumn(['origen', 'atendido_por', 'atendido_at', 'cerrado_at', 'horas_sin_transmision']);
        });
    }
};
