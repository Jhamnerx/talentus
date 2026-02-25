<?php

namespace App\Livewire\Admin\Planes;

use App\Models\Plan;
use Livewire\Component;
use Livewire\Attributes\On;

class DeleteModal extends Component
{
    public $modalDelete = false;
    public ?Plan $plan = null;

    public function render()
    {
        return view('livewire.admin.planes.delete-modal');
    }

    #[On('open-modal-delete-plan')]
    public function openModal(Plan $plan)
    {
        $this->plan = $plan;
        $this->modalDelete = true;
    }

    public function closeModal()
    {
        $this->modalDelete = false;
        $this->plan = null;
    }

    public function delete()
    {
        if (!$this->plan) {
            $this->notification()->error(
                title: 'ERROR',
                description: 'Plan no encontrado'
            );
            return;
        }

        try {
            // Verificar si tiene suscripciones activas
            $activeSubscriptions = $this->plan->subscriptions()
                ->whereNull('ends_at')
                ->orWhere('ends_at', '>', now())
                ->count();

            if ($activeSubscriptions > 0) {
                $this->notification()->warning(
                    title: 'NO SE PUEDE ELIMINAR',
                    description: 'Este plan tiene ' . $activeSubscriptions . ' suscripciones activas. Desactívalo en lugar de eliminarlo.'
                );
                $this->closeModal();
                return;
            }

            $planName = $this->plan->name['es'];
            $this->plan->delete();

            $this->closeModal();
            $this->notification()->success(
                title: 'PLAN ELIMINADO',
                description: 'El plan ' . $planName . ' fue eliminado correctamente'
            );
            $this->dispatch('plan-saved');
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }
}
