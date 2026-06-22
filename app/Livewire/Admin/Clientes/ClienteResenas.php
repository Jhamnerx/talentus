<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\Resena;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class ClienteResenas extends Component
{
    use WireUiActions;

    public Clientes $cliente;

    public string $comentario = '';

    public ?int $calificacion = null;

    public function guardar(): void
    {
        abort_unless(auth()->user()->can('gestionar-resenas-cliente'), 403);

        $this->validate([
            'comentario' => 'required|string|max:2000',
            'calificacion' => 'nullable|integer|between:1,5',
        ], [
            'comentario.required' => 'Escribe un comentario.',
            'comentario.max' => 'El comentario no puede superar los 2000 caracteres.',
            'calificacion.between' => 'La calificación debe estar entre 1 y 5.',
        ]);

        $team = auth()->user()->teams()->first();

        if (! $team) {
            $this->notification()->error('Error', 'Debes pertenecer a un equipo para registrar reseñas.');
            return;
        }

        Resena::create([
            'empresa_id' => session('empresa', 1),
            'cliente_id' => $this->cliente->id,
            'user_id' => auth()->id(),
            'team_id' => $team->id,
            'comentario' => $this->comentario,
            'calificacion' => $this->calificacion,
        ]);

        $this->reset(['comentario', 'calificacion']);

        $this->notification()->success('Listo', 'Reseña agregada.');
    }

    public function render()
    {
        $resenas = $this->cliente->resenas()
            ->with(['user', 'team'])
            ->latest()
            ->limit(20)
            ->get();

        return view('livewire.admin.clientes.cliente-resenas', [
            'resenas' => $resenas,
        ]);
    }
}
