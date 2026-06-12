<?php

namespace App\Livewire\Admin\Ajustes\Sla;

use App\Models\SlaPlanRule;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Profiles extends Component
{
    use WireUiActions;

    /**
     * Estructura: $rules[tier][priority] = ['tr_hours','ts_remote_hours','tr_business_hours','ts_business_hours']
     *
     * @var array<string, array<string, array<string, mixed>>>
     */
    public array $rules = [];

    public string $activeTier = 'basico';

    public const TIERS = ['basico', 'estandar', 'premium', 'mininter'];
    public const PRIORITIES = ['urgent', 'high', 'medium', 'low'];

    public function mount(): void
    {
        $this->loadRules();
    }

    public function loadRules(): void
    {
        $existing = SlaPlanRule::all()->keyBy(fn ($r) => $r->plan_type . '|' . $r->priority);

        $data = [];
        foreach (self::TIERS as $tier) {
            foreach (self::PRIORITIES as $priority) {
                $rule = $existing->get($tier . '|' . $priority);
                $data[$tier][$priority] = [
                    'tr_hours'          => $rule->tr_hours ?? 0,
                    'ts_remote_hours'   => $rule->ts_remote_hours ?? 0,
                    'tr_business_hours' => (bool) ($rule->tr_business_hours ?? false),
                    'ts_business_hours' => (bool) ($rule->ts_business_hours ?? false),
                ];
            }
        }

        $this->rules = $data;
    }

    public function setTier(string $tier): void
    {
        if (in_array($tier, self::TIERS, true)) {
            $this->activeTier = $tier;
        }
    }

    public function rules(): array
    {
        $rules = [];
        foreach (self::TIERS as $tier) {
            foreach (self::PRIORITIES as $priority) {
                $rules["rules.$tier.$priority.tr_hours"]          = ['required', 'numeric', 'min:0'];
                $rules["rules.$tier.$priority.ts_remote_hours"]   = ['required', 'numeric', 'min:0'];
                $rules["rules.$tier.$priority.tr_business_hours"] = ['boolean'];
                $rules["rules.$tier.$priority.ts_business_hours"] = ['boolean'];
            }
        }
        return $rules;
    }

    public function save(): void
    {
        $this->validate();

        foreach (self::TIERS as $tier) {
            foreach (self::PRIORITIES as $priority) {
                $row = $this->rules[$tier][$priority];
                SlaPlanRule::updateOrCreate(
                    ['plan_type' => $tier, 'priority' => $priority],
                    [
                        'tr_hours'          => $row['tr_hours'],
                        'ts_remote_hours'   => $row['ts_remote_hours'],
                        'tr_business_hours' => (bool) $row['tr_business_hours'],
                        'ts_business_hours' => (bool) $row['ts_business_hours'],
                    ]
                );
            }
        }

        $this->notification()->success(
            title: 'PERFILES SLA ACTUALIZADOS',
            description: 'Los tiempos TR/TS se guardaron correctamente.'
        );
    }

    public function render()
    {
        return view('livewire.admin.ajustes.sla.profiles', [
            'tierLabels'     => collect(self::TIERS)->mapWithKeys(fn ($t) => [$t => SlaPlanRule::planLabel($t)]),
            'priorityLabels' => [
                'urgent' => 'P1 — Crítico',
                'high'   => 'P2 — Alto',
                'medium' => 'P3 — Medio',
                'low'    => 'P4 — Bajo',
            ],
        ]);
    }
}
