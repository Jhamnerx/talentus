<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use App\Models\Productos;
use Livewire\Component;
use WireUi\Traits\WireUiActions;
use Livewire\Attributes\On;

class EditModal extends Component
{
    use WireUiActions;

    public $modalEdit = false;
    public ?Plan $plan = null;

    // Campos del plan
    public $name, $slug, $description;
    public $is_active;
    public $price, $signup_fee, $currency;
    public $trial_period, $trial_interval;
    public $invoice_period, $invoice_interval;
    public $grace_period, $grace_interval;
    public $prorate_day, $prorate_period, $prorate_extend_due;
    public $active_subscribers_limit;
    public $sort_order;

    // Catálogos
    public $intervals = [];
    public $currencies = ['PEN', 'USD'];

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
        return view('livewire.admin.planes.edit-modal');
    }

    #[On('open-modal-edit-plan')]
    public function openModal(Plan $plan)
    {
        $this->resetValidation();
        $this->plan = $plan;

        // Cargar datos del plan
        $this->name = is_array($plan->name) ? ($plan->name['es'] ?? $plan->name['en'] ?? '') : ($plan->name ?? '');
        $this->slug = $plan->slug;
        $this->description = is_array($plan->description) ? ($plan->description['es'] ?? $plan->description['en'] ?? '') : ($plan->description ?? '');
        $this->is_active = $plan->is_active;
        $this->price = $plan->price;
        $this->signup_fee = $plan->signup_fee;
        $this->currency = $plan->currency;
        $this->trial_period = $plan->trial_period;
        $this->trial_interval = $plan->trial_interval;
        $this->invoice_period = $plan->invoice_period;
        $this->invoice_interval = $plan->invoice_interval;
        $this->grace_period = $plan->grace_period;
        $this->grace_interval = $plan->grace_interval;
        $this->prorate_day = $plan->prorate_day;
        $this->prorate_period = $plan->prorate_period;
        $this->prorate_extend_due = $plan->prorate_extend_due;
        $this->active_subscribers_limit = $plan->active_subscribers_limit;
        $this->sort_order = $plan->sort_order;

        $this->modalEdit = true;
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetProp();
    }

    public function updatedName($value)
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($value);
        }
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'price' => 'required|numeric|min:0',
            'signup_fee' => 'nullable|numeric|min:0',
            'currency' => 'required|string|size:3',
            'trial_period' => 'nullable|integer|min:0',
            'trial_interval' => 'required|string',
            'invoice_period' => 'required|integer|min:1',
            'invoice_interval' => 'required|string',
            'grace_period' => 'nullable|integer|min:0',
            'grace_interval' => 'required|string',
            'prorate_day' => 'nullable|integer|min:1|max:31',
            'prorate_period' => 'nullable|integer|min:0',
            'prorate_extend_due' => 'nullable|integer|min:0',
            'active_subscribers_limit' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'price.required' => 'El precio es obligatorio',
            'price.min' => 'El precio debe ser mayor o igual a 0',
            'invoice_period.required' => 'El periodo de facturación es obligatorio',
            'invoice_period.min' => 'El periodo debe ser al menos 1',
        ]);

        try {
            $this->plan->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_active' => $this->is_active,
                'price' => $this->price,
                'signup_fee' => $this->signup_fee ?? 0,
                'currency' => $this->currency,
                'trial_period' => $this->trial_period ?? 0,
                'trial_interval' => $this->trial_interval,
                'invoice_period' => $this->invoice_period,
                'invoice_interval' => $this->invoice_interval,
                'grace_period' => $this->grace_period ?? 0,
                'grace_interval' => $this->grace_interval,
                'prorate_day' => $this->prorate_day,
                'prorate_period' => $this->prorate_period,
                'prorate_extend_due' => $this->prorate_extend_due,
                'active_subscribers_limit' => $this->active_subscribers_limit,
                'sort_order' => $this->sort_order ?? 0,
                'producto_id' => Productos::where('es_servicio_cobro', true)->value('id'),
            ]);

            $this->closeModal();
            $this->notification()->success(
                title: 'PLAN ACTUALIZADO',
                description: 'El plan ' . $this->plan->name . ' fue actualizado correctamente'
            );
            $this->dispatch('plan-saved');
            $this->resetProp();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function resetProp()
    {
        $this->reset([
            'name',
            'slug',
            'description',
            'is_active',
            'price',
            'signup_fee',
            'currency',
            'trial_period',
            'trial_interval',
            'invoice_period',
            'invoice_interval',
            'grace_period',
            'grace_interval',
            'prorate_day',
            'prorate_period',
            'prorate_extend_due',
            'active_subscribers_limit',
            'sort_order',
            'plan'
        ]);
    }
}
