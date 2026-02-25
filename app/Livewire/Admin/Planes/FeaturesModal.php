<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use Livewire\Component;
use Livewire\Attributes\On;
use Laravelcm\Subscriptions\Models\Feature;
use Laravelcm\Subscriptions\Models\SubscriptionUsage;

class FeaturesModal extends Component
{
    public $modalFeatures = false;
    public ?Plan $plan = null;

    // Features existentes
    public $features = [];

    // Nuevo feature
    public $name, $slug, $description, $value, $resettable_period = 0, $resettable_interval = 'month', $sort_order = 0;

    // Catálogos
    public $intervals = [];

    public function mount()
    {
        $this->intervals = [
            'day' => 'Día(s)',
            'week' => 'Semana(s)',
            'month' => 'Mes(es)',
            'year' => 'Año(s)',
        ];
    }

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

    public function updatedName($value)
    {
        // Generar slug automáticamente
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    public function addFeature()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'required|string',
            'resettable_period' => 'nullable|integer|min:0',
            'resettable_interval' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'slug.required' => 'El slug es obligatorio',
            'value.required' => 'El valor es obligatorio',
        ]);

        try {
            // Verificar que no exista el slug para este plan
            $exists = Feature::where('plan_id', $this->plan->id)
                ->where('slug', $this->slug)
                ->exists();

            if ($exists) {
                $this->notification()->error(
                    title: 'SLUG DUPLICADO',
                    description: 'Ya existe una característica con este slug para este plan'
                );
                return;
            }

            Feature::create([
                'plan_id' => $this->plan->id,
                'name' => ['es' => $this->name, 'en' => $this->name], // JSON multi-idioma
                'slug' => $this->slug,
                'description' => $this->description ? ['es' => $this->description, 'en' => $this->description] : null,
                'value' => $this->value,
                'resettable_period' => $this->resettable_period ?? 0,
                'resettable_interval' => $this->resettable_interval,
                'sort_order' => $this->sort_order ?? 0,
            ]);

            $this->notification()->success(
                title: 'CARACTERÍSTICA AGREGADA',
                description: 'La característica fue agregada correctamente'
            );

            $this->resetFeatureForm();
            $this->loadFeatures();
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
            $featureName = is_array($feature->name) ? ($feature->name['es'] ?? $feature->name['en'] ?? 'característica') : $feature->name;

            // Verificar si hay suscripciones usando esta feature
            $usageCount = SubscriptionUsage::where('feature_id', $featureId)->count();

            if ($usageCount > 0) {
                $this->notification()->warning(
                    title: 'NO SE PUEDE ELIMINAR',
                    description: 'Esta característica tiene ' . $usageCount . ' registros de uso. No se puede eliminar.'
                );
                return;
            }

            $feature->delete();

            $this->notification()->success(
                title: 'CARACTERÍSTICA ELIMINADA',
                description: 'La característica ' . $featureName . ' fue eliminada'
            );

            $this->loadFeatures();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function resetFeatureForm()
    {
        $this->reset(['name', 'slug', 'description', 'value', 'resettable_period', 'resettable_interval', 'sort_order']);
        $this->resettable_period = 0;
        $this->resettable_interval = 'month';
        $this->sort_order = 0;
    }

    public function resetProp()
    {
        $this->reset(['plan', 'features', 'name', 'slug', 'description', 'value', 'resettable_period', 'resettable_interval', 'sort_order']);
    }
}
