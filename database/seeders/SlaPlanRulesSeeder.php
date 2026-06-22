<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SlaPlanRule;

class SlaPlanRulesSeeder extends Seeder
{
    /**
     * Siembra los tiempos TR/TS por plan y prioridad según los documentos SLA de Talentus.
     * tr_business_hours / ts_business_hours = true → cuenta solo horas L-V 09:00-18:00
     */
    public function run(): void
    {
        $rules = [
            // ── BÁSICO "Control Mínimo" ── L-V 09-18h ──────────────────────────────
            // P1 ≤4h hábiles TR | ≤48h calendario TS
            ['plan_type' => 'basico', 'priority' => 'urgent', 'tr_hours' => 4,     'ts_remote_hours' => 48,   'tr_business_hours' => true,  'ts_business_hours' => false],
            // P2 ≤8h hábiles TR | ≤72h calendario TS
            ['plan_type' => 'basico', 'priority' => 'high',   'tr_hours' => 8,     'ts_remote_hours' => 72,   'tr_business_hours' => true,  'ts_business_hours' => false],
            // P3 ≤1 día hábil TR (9h) | ≤5 días hábiles TS (45h)
            ['plan_type' => 'basico', 'priority' => 'medium', 'tr_hours' => 9,     'ts_remote_hours' => 45,   'tr_business_hours' => true,  'ts_business_hours' => true],
            // P4 ≤2 días hábiles TR (18h) | ≤10 días hábiles TS (90h)
            ['plan_type' => 'basico', 'priority' => 'low',    'tr_hours' => 18,    'ts_remote_hours' => 90,   'tr_business_hours' => true,  'ts_business_hours' => true],

            // ── ESTÁNDAR "Gestión Operativa" ─────────────────────────────────────────
            // P1 24/7: ≤5 min TR | ≤2h calendario TS
            ['plan_type' => 'estandar', 'priority' => 'urgent', 'tr_hours' => 0.083, 'ts_remote_hours' => 2,  'tr_business_hours' => false, 'ts_business_hours' => false],
            // P2: ≤60 min TR | ≤12h calendario TS
            ['plan_type' => 'estandar', 'priority' => 'high',   'tr_hours' => 1,     'ts_remote_hours' => 12, 'tr_business_hours' => false, 'ts_business_hours' => false],
            // P3: ≤4h hábiles TR | ≤48h calendario TS
            ['plan_type' => 'estandar', 'priority' => 'medium', 'tr_hours' => 4,     'ts_remote_hours' => 48, 'tr_business_hours' => true,  'ts_business_hours' => false],
            // P4: ≤1 día hábil TR (9h) | ≤5 días hábiles TS (45h)
            ['plan_type' => 'estandar', 'priority' => 'low',    'tr_hours' => 9,     'ts_remote_hours' => 45, 'tr_business_hours' => true,  'ts_business_hours' => true],

            // ── PREMIUM "Grandes Flotas / Regulados" ─────────────────────────────────
            // P1 24/7: ≤2 min TR | ≤1h calendario TS
            ['plan_type' => 'premium', 'priority' => 'urgent', 'tr_hours' => 0.033, 'ts_remote_hours' => 1,  'tr_business_hours' => false, 'ts_business_hours' => false],
            // P2: ≤30 min TR | ≤6h calendario TS
            ['plan_type' => 'premium', 'priority' => 'high',   'tr_hours' => 0.5,   'ts_remote_hours' => 6,  'tr_business_hours' => false, 'ts_business_hours' => false],
            // P3: ≤2h TR | ≤24h calendario TS
            ['plan_type' => 'premium', 'priority' => 'medium', 'tr_hours' => 2,     'ts_remote_hours' => 24, 'tr_business_hours' => false, 'ts_business_hours' => false],
            // P4: ≤8h TR | ≤72h calendario TS
            ['plan_type' => 'premium', 'priority' => 'low',    'tr_hours' => 8,     'ts_remote_hours' => 72, 'tr_business_hours' => false, 'ts_business_hours' => false],

            // ── MININTER / SIPCOP-M (24/7) ───────────────────────────────────────────
            // P1: ≤10 min TR | ≤2h TS
            ['plan_type' => 'mininter', 'priority' => 'urgent', 'tr_hours' => 0.167, 'ts_remote_hours' => 2,  'tr_business_hours' => false, 'ts_business_hours' => false],
            // P2: ≤30 min TR | ≤6h TS
            ['plan_type' => 'mininter', 'priority' => 'high',   'tr_hours' => 0.5,   'ts_remote_hours' => 6,  'tr_business_hours' => false, 'ts_business_hours' => false],
            // P3: ≤2h TR | ≤24h TS
            ['plan_type' => 'mininter', 'priority' => 'medium', 'tr_hours' => 2,     'ts_remote_hours' => 24, 'tr_business_hours' => false, 'ts_business_hours' => false],
            // P4: ≤8h TR | ≤72h TS
            ['plan_type' => 'mininter', 'priority' => 'low',    'tr_hours' => 8,     'ts_remote_hours' => 72, 'tr_business_hours' => false, 'ts_business_hours' => false],
        ];

        foreach ($rules as $rule) {
            SlaPlanRule::updateOrCreate(
                ['plan_type' => $rule['plan_type'], 'priority' => $rule['priority']],
                $rule
            );
        }
    }
}
