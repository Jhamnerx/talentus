<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $ticketId;
    public $ticketCode = '';

    protected $listeners = ['open-modal-delete-ticket' => 'openModal'];

    public function render()
    {
        return view('livewire.admin.tickets.delete');
    }

    public function openModal($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $this->authorize('delete', $ticket);

        $this->ticketId = $ticket->id;
        $this->ticketCode = $ticket->code;
        $this->showModal = true;
    }

    public function delete()
    {
        $ticket = Ticket::findOrFail($this->ticketId);
        $this->authorize('delete', $ticket);

        $ticket->delete();

        $this->showModal = false;
        $this->dispatch('update-table');
        $this->notification()->success('Ticket eliminado', 'El ticket ' . $this->ticketCode . ' fue eliminado');
    }
}
