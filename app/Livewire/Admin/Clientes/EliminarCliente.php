<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Livewire\Attributes\On;

class EliminarCliente extends Component
{
    public $mostrarModal = false;
    public $clienteSeleccionado = null;

    #[On('abrir-modal-eliminar-cliente')]
    public function abrirModal(Clientes $cliente)
    {
        $this->clienteSeleccionado = $cliente;
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->clienteSeleccionado = null;
    }

    public function eliminar()
    {
        try {
            if (!$this->clienteSeleccionado) {
                throw new \Exception('No se ha seleccionado ningún cliente');
            }

            // Descomentar cuando esté listo
            $this->clienteSeleccionado->delete();

            $this->cerrarModal();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'Cliente Eliminado',
                mensaje: 'Se eliminó correctamente el cliente'
            );

            $this->dispatch('update-table');
        } catch (\Throwable $th) {
            $this->dispatch('notify-toast', [
                'icon' => 'error',
                'title' => 'Error',
                'mensaje' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.clientes.eliminar-cliente');
    }
}
