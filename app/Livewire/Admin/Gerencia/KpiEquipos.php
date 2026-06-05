<?php

namespace App\Livewire\Admin\Gerencia;

use App\Models\Team;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

#[Layout('layouts.admin')]
class KpiEquipos extends Component
{
    use WireUiActions;

    // Modal de agregar miembro
    public bool $modalAgregar = false;
    public ?string $areaActiva  = null;
    public string  $nombreArea  = '';
    public ?int    $equipoId    = null;

    // Formulario de agregar
    public ?int    $userId      = null;
    public string  $rolEnEquipo = 'miembro';

    // Búsqueda de usuarios disponibles
    public string  $busquedaUsuario = '';

    public function mount(): void
    {
        // Asegurar que existe un equipo por cada área KPI
        $empresaId = session('empresa', 1);
        foreach (Team::KPI_AREAS as $slug => $nombre) {
            Team::firstOrCreate(
                ['empresa_id' => $empresaId, 'kpi_area' => $slug],
                [
                    'name'        => 'Equipo ' . $nombre,
                    'description' => 'Equipo del área de ' . $nombre . ' para medición de KPIs.',
                    'is_active'   => true,
                ]
            );
        }
    }

    public function abrirModalAgregar(string $area): void
    {
        $equipo = Team::where('kpi_area', $area)->first();

        if (! $equipo) {
            $this->notification()->error('Error', 'No se encontró el equipo para esa área.');
            return;
        }

        $this->areaActiva      = $area;
        $this->nombreArea      = Team::KPI_AREAS[$area] ?? $area;
        $this->equipoId        = $equipo->id;
        $this->userId          = null;
        $this->rolEnEquipo     = 'miembro';
        $this->busquedaUsuario = '';
        $this->modalAgregar    = true;
    }

    public function agregarMiembro(): void
    {
        $this->validate([
            'userId'      => 'required|integer|exists:users,id',
            'rolEnEquipo' => 'required|in:lider,miembro',
        ], [
            'userId.required' => 'Selecciona un usuario.',
            'userId.exists'   => 'El usuario seleccionado no existe.',
        ]);

        $equipo = Team::findOrFail($this->equipoId);

        if ($equipo->users()->where('user_id', $this->userId)->exists()) {
            $this->notification()->warning('Aviso', 'El usuario ya pertenece a este equipo.');
            return;
        }

        $equipo->users()->attach($this->userId, ['role_in_team' => $this->rolEnEquipo]);

        $this->notification()->success('Listo', 'Miembro agregado al equipo.');
        $this->modalAgregar = false;
    }

    public function quitarMiembro(int $equipoId, int $userId): void
    {
        $equipo = Team::findOrFail($equipoId);
        $equipo->users()->detach($userId);

        $this->notification()->success('Listo', 'Miembro removido del equipo.');
    }

    public function cambiarRol(int $equipoId, int $userId, string $rol): void
    {
        $equipo = Team::findOrFail($equipoId);
        $equipo->users()->updateExistingPivot($userId, ['role_in_team' => $rol]);
        $this->notification()->success('Actualizado', 'Rol actualizado correctamente.');
    }

    public function usuariosDisponibles(): array
    {
        if (! $this->equipoId) {
            return [];
        }

        $miembrosActuales = Team::findOrFail($this->equipoId)
            ->users()
            ->pluck('users.id');

        return User::whereNotIn('id', $miembrosActuales)
            ->when($this->busquedaUsuario, fn ($q) => $q->where('name', 'like', '%' . $this->busquedaUsuario . '%'))
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'email'])
            ->toArray();
    }

    public function render()
    {
        $areas  = Team::KPI_AREAS;
        $equipos = Team::with(['users' => fn ($q) => $q->withPivot('role_in_team')])
            ->whereNotNull('kpi_area')
            ->get()
            ->keyBy('kpi_area');

        $usuariosDisponibles = $this->usuariosDisponibles();

        return view('livewire.admin.gerencia.kpi-equipos', compact('areas', 'equipos', 'usuariosDisponibles'));
    }
}