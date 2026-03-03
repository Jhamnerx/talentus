<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Models\SubscriptionUsage;

class FeaturesModal extends Component
{
    use WireUiActions;

    public $modalFeatures = false;
    public ?Plan $plan = null;

    // Features existentes
    public $features = [];

    // Nuevo feature
    public $name, $description;

    public function render()
    {
        return view('livewire.admin.planes.features-modal');
    }

    #[On('open-modal-features')]
    public function openModal(Plan $plan)
    {
        $this->resetValidation();
        $this->plan = $plan;
        $this->loadFeatures();
        $this->modalFeatures = true;
    }

    public function closeModal()
    {
        $this->modalFeatures = false;
        $this->resetProp();
    }

    public function loadFeatures()
    {
        if (!$this->plan) return;

        $this->features = $this->plan->features()
            ->orderBy('sort_order')
            ->get()
            ->toArray();
    }

    public function addFeature()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'El nombre es obligatorio',
        ]);

        try {
            $slug = \Illuminate\Support\Str::slug($this->name);

            // Evitar slugs duplicados dentro del mismo plan
            $base = $slug;
            $i = 1;
            while (Feature::where('plan_id', $this->plan->id)->where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            Feature::create([
                'plan_id'             => $this->plan->id,
                'name'                => $this->name,
                'slug'                => $slug,
                'description'         => $this->description ?: null,
                'value'               => 'true',
                'resettable_period'   => 0,
                'resettable_interval' => 'month',
                'sort_order'          => $this->plan->features()->count(),
            ]);

            $this->notification()->success(
                title: 'CARACTERÍSTICA AGREGADA',
                description: '"' . $this->name . '" fue agregada correctamente'
            );

            $this->reset(['name', 'description']);
            $this->loadFeatures();
            $this->dispatch('feature-added');
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function deleteFeature($featureId)
    {
        try {
            $feature = Feature::findOrFail($featureId);
            $featureName = is_array($feature->name)
                ? ($feature->name['es'] ?? $feature->name['en'] ?? 'característica')
                : $feature->name;

            $usageCount = SubscriptionUsage::where('feature_id', $featureId)->count();

            if ($usageCount > 0) {
                $this->notification()->warning(
                    title: 'NO SE PUEDE ELIMINAR',
                    description: 'Esta característica tiene ' . $usageCount . ' registros de uso.'
                );
                return;
            }

            $feature->delete();

            $this->notification()->success(
                title: 'CARACTERÍSTICA ELIMINADA',
                description: '"' . $featureName . '" fue eliminada'
            );

            $this->loadFeatures();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function resetProp()
    {
        $this->reset(['plan', 'features', 'name', 'description']);
    }
}
