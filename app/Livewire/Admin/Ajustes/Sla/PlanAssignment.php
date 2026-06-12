<?php

namespace App\Livewire\Admin\Ajustes\Sla;

use App\Models\Plan;
use App\Models\SlaPlanRule;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class PlanAssignment extends Component
{
    use WithPagination, WireUiActions;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updateTier(int $planId, string $tier): void
    {
        if (!in_array($tier, SlaPlanRule::planTypes(), true)) {
            return;
        }

        $plan = Plan::find($planId);
        if (!$plan) {
            return;
        }

        $plan->update(['sla_tier' => $tier]);

        $this->notification()->success(
            title: 'PERFIL ASIGNADO',
            description: 'El plan ahora usa el perfil ' . SlaPlanRule::planLabel($tier) . '.'
        );
    }

    public function render()
    {
        $plans = Plan::query()
            ->when($this->search, function ($q) {
                $q->where('slug', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('livewire.admin.ajustes.sla.plan-assignment', [
            'plans'      => $plans,
            'tierLabels' => collect(SlaPlanRule::planTypes())->mapWithKeys(fn ($t) => [$t => SlaPlanRule::planLabel($t)]),
        ]);
    }
}
