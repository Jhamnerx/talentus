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
        if (Schema::hasColumn('clientes', 'sla_plan')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->dropColumn('sla_plan');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('clientes', 'sla_plan')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->string('sla_plan', 20)->default('basico')->after('is_active');
            });
        }
    }
};
