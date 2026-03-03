<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use App\Models\Productos;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class CreateModal extends Component
{
    use WireUiActions;

    public $modalCreate = false;

    // Campos del plan
    public $name, $slug, $description;
    public $is_active = true;
    public $price = 0, $signup_fee = 0, $currency = 'PEN';
    public $trial_period = 0, $trial_interval = 'day';
    public $invoice_period = 1, $invoice_interval = 'month';
    public $grace_period = 0, $grace_interval = 'day';
    public $prorate_day, $prorate_period, $prorate_extend_due;
    public $active_subscribers_limit;
    public $sort_order = 0;

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
        return view('livewire.admin.planes.create-modal');
    }

    #[On('open-modal-create-plan')]
    public function openModal()
    {
        $this->resetValidation();
        $this->resetProp();
        $this->modalCreate = true;
    }

    public function closeModal()
    {
        $this->modalCreate = false;
        $this->resetProp();
    }

    public function updatedName($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    public function save()
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
            $plan = Plan::create([
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
                title: 'PLAN CREADO',
                description: 'El plan ' . $plan->name . ' fue creado correctamente'
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
        ]);
        $this->is_active = true;
        $this->price = 0;
        $this->signup_fee = 0;
        $this->currency = 'PEN';
        $this->trial_period = 0;
        $this->trial_interval = 'day';
        $this->invoice_period = 1;
        $this->invoice_interval = 'month';
        $this->grace_period = 0;
        $this->grace_interval = 'day';
        $this->sort_order = 0;
    }
}
