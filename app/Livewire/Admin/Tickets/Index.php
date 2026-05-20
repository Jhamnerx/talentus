<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $from = '';
    public $to = '';

    public function mount(): void
    {
        $this->authorize('ver-ticket');
    }

    protected $listeners = [
        'render' => 'render',
        'update-table' => 'render',
    ];

    public function render()
    {
        $tickets = Ticket::query()
            ->with(['customer', 'assignedTo', 'category'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', function ($customerQuery) {
                            $customerQuery->where('razon_social', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter, fn($query) => $query->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn($query) => $query->where('priority', $this->priorityFilter))
            ->when($this->from && $this->to, function ($query) {
                $query->whereBetween('created_at', [
                    $this->from . ' 00:00:00',
                    $this->to . ' 23:59:59'
                ]);
            })
            ->latest('last_activity_at')
            ->paginate(10);

        return view('livewire.admin.tickets.index', [
            'tickets' => $tickets,
            'statuses' => TicketStatus::options(),
            'priorities' => TicketPriority::options(),
        ]);
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = now()->format('Y-m-d');
                $this->to = now()->format('Y-m-d');
                break;
            case '7':
                $this->from = now()->subDays(7)->format('Y-m-d');
                $this->to = now()->format('Y-m-d');
                break;
            case '30':
                $this->from = now()->subMonth()->format('Y-m-d');
                $this->to = now()->format('Y-m-d');
                break;
            case '12':
                $this->from = now()->subYear()->format('Y-m-d');
                $this->to = now()->format('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create-ticket');
    }

    public function openModalEdit(Ticket $ticket)
    {
        $this->dispatch('open-modal-edit-ticket', ticketId: $ticket->id);
    }

    public function openModalDelete(Ticket $ticket)
    {
        $this->dispatch('open-modal-delete-ticket', ticketId: $ticket->id);
    }
}
