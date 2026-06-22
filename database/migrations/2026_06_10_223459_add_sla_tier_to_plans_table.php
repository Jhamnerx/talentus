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
        Schema::table('plans', function (Blueprint $table) {
            // Perfil SLA del plan: basico | estandar | premium | mininter.
            // Determina los tiempos TR/TS (sla_plan_rules) usados por los tickets.
            $table->string('sla_tier', 20)->nullable()->after('slug')->index();
        });

        // Backfill best-effort según el nombre/slug del plan. Editable luego en Ajustes → SLA.
        $this->backfillTiers();
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropIndex(['sla_tier']);
            $table->dropColumn('sla_tier');
        });
    }

    private function backfillTiers(): void
    {
        $plans = \Illuminate\Support\Facades\DB::table('plans')->select('id', 'slug', 'name')->get();

        foreach ($plans as $plan) {
            $haystack = strtolower(($plan->slug ?? '') . ' ' . ($plan->name ?? ''));

            $tier = match (true) {
                str_contains($haystack, 'mininter')                                              => 'mininter',
                str_contains($haystack, 'premium')                                               => 'premium',
                str_contains($haystack, 'sutran'), str_contains($haystack, 'osinerm'),
                str_contains($haystack, 'osinergmin'), str_contains($haystack, 'municipalidad')  => 'premium',
                str_contains($haystack, 'standar'), str_contains($haystack, 'estandar')          => 'estandar',
                default                                                                          => 'basico',
            };

            \Illuminate\Support\Facades\DB::table('plans')->where('id', $plan->id)->update(['sla_tier' => $tier]);
        }
    }
};
