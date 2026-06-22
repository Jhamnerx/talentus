<?php

namespace App\Livewire\Admin\Portal;

use App\Models\ClienteUser;
use App\Notifications\Portal\PortalAccesoActualizadoNotification;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AccesosIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $estado = 'pendiente';

    public ?int $rechazandoId = null;

    public string $motivoRechazo = '';

    /**
     * @var array<int, string>
     */
    public array $estados = ['pendiente', 'aprobado', 'rechazado', 'suspendido'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEstado(): void
    {
        $this->resetPage();
    }

    public function aprobar(int $id): void
    {
        $this->authorize('gestionar-accesos-portal');

        $clienteUser = $this->buscar($id);
        $clienteUser->update(['estado' => 'aprobado']);
        $clienteUser->notify(new PortalAccesoActualizadoNotification('aprobado'));

        $this->dispatch('toast', type: 'success', message: 'Acceso aprobado.');
    }

    public function suspender(int $id): void
    {
        $this->authorize('gestionar-accesos-portal');

        $clienteUser = $this->buscar($id);
        $clienteUser->update(['estado' => 'suspendido']);
        $clienteUser->tokens()->delete();
        $clienteUser->notify(new PortalAccesoActualizadoNotification('suspendido'));

        $this->dispatch('toast', type: 'success', message: 'Acceso suspendido.');
    }

    public function reactivar(int $id): void
    {
        $this->authorize('gestionar-accesos-portal');

        $clienteUser = $this->buscar($id);
        $clienteUser->update(['estado' => 'aprobado']);
        $clienteUser->notify(new PortalAccesoActualizadoNotification('aprobado'));

        $this->dispatch('toast', type: 'success', message: 'Acceso reactivado.');
    }

    public function abrirRechazo(int $id): void
    {
        $this->authorize('gestionar-accesos-portal');

        $this->rechazandoId = $id;
        $this->motivoRechazo = '';
    }

    public function cancelarRechazo(): void
    {
        $this->rechazandoId = null;
        $this->motivoRechazo = '';
    }

    public function rechazar(): void
    {
        $this->authorize('gestionar-accesos-portal');

        if (! $this->rechazandoId) {
            return;
        }

        if (trim($this->motivoRechazo) === '') {
            throw ValidationException::withMessages([
                'motivoRechazo' => 'Indica el motivo del rechazo.',
            ]);
        }

        $clienteUser = $this->buscar($this->rechazandoId);
        $clienteUser->update(['estado' => 'rechazado']);
        $clienteUser->tokens()->delete();
        $clienteUser->notify(new PortalAccesoActualizadoNotification('rechazado', $this->motivoRechazo));

        $this->cancelarRechazo();
        $this->dispatch('toast', type: 'success', message: 'Acceso rechazado.');
    }

    protected function buscar(int $id): ClienteUser
    {
        return ClienteUser::with('cliente')->findOrFail($id);
    }

    public function render()
    {
        $accesos = ClienteUser::query()
            ->with('cliente')
            ->when($this->estado !== '', fn ($query) => $query->where('estado', $this->estado))
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhereHas('cliente', function ($c) {
                            $c->where('razon_social', 'like', "%{$this->search}%")
                                ->orWhere('numero_documento', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        $pendientesCount = ClienteUser::where('estado', 'pendiente')->count();

        return view('livewire.admin.portal.accesos-index', compact('accesos', 'pendientesCount'));
    }
}
