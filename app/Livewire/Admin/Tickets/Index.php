<?php

namespace App\Livewire\Admin\Tickets;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Exports\TicketsExport;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WithPagination, WireUiActions;

    public string  $search          = '';
    public ?string $statusFilter    = null;
    public ?string $priorityFilter  = null;
    public ?string $assignedFilter  = null;
    public ?string $categoryFilter  = null;
    public ?string $from            = null;
    public ?string $to              = null;
    public int     $perPage         = 15;

    // Acciones masivas
    public array  $selectedTickets = [];
    public bool   $selectAll       = false;
    public string $bulkStatus      = '';

    public function mount(): void
    {
        $this->authorize('ver-ticket');
    }

    protected $listeners = [
        'render'       => 'render',
        'update-table' => 'render',
    ];

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedTickets = $this->getVisibleTicketIds();
        } else {
            $this->selectedTickets = [];
        }
    }

    public function render()
    {
        $query = Ticket::query()
            ->with(['customer', 'assignedTo', 'category'])
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhereHas('customer', fn($c) => $c->where('razon_social', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn($q) => $q->where('priority', $this->priorityFilter))
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->assignedFilter === 'mine', fn($q) => $q->where('assigned_to', Auth::id()))
            ->when($this->assignedFilter && $this->assignedFilter !== 'mine', fn($q) => $q->where('assigned_to', $this->assignedFilter))
            ->when($this->from && $this->to, fn($q) => $q->whereBetween('created_at', [
                Carbon::parse($this->from)->startOfDay(),
                Carbon::parse($this->to)->endOfDay(),
            ]))
            ->latest('last_activity_at');

        $tickets = $query->paginate($this->perPage);

        $agents = User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'agente']))
            ->orderBy('name')->get(['id', 'name']);

        $categories = TicketCategory::active()->orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.tickets.index', [
            'tickets'    => $tickets,
            'statuses'   => TicketStatus::options(),
            'priorities' => TicketPriority::options(),
            'agents'     => $agents,
            'categories' => $categories,
        ]);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->search          = '';
        $this->statusFilter    = null;
        $this->priorityFilter  = null;
        $this->assignedFilter  = null;
        $this->categoryFilter  = null;
        $this->from            = null;
        $this->to              = null;
        $this->resetPage();
    }

    public function filter($dias): void
    {
        switch ($dias) {
            case '1':
                $this->from = now()->format('Y-m-d');
                $this->to   = now()->format('Y-m-d');
                break;
            case '7':
                $this->from = now()->subDays(7)->format('Y-m-d');
                $this->to   = now()->format('Y-m-d');
                break;
            case '30':
                $this->from = now()->subMonth()->format('Y-m-d');
                $this->to   = now()->format('Y-m-d');
                break;
            case '12':
                $this->from = now()->subYear()->format('Y-m-d');
                $this->to   = now()->format('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to   = '';
                break;
        }
    }

    public function bulkAction(string $action): void
    {
        if (empty($this->selectedTickets)) {
            $this->notification()->warning('Selecciona al menos un ticket.');
            return;
        }

        $count = count($this->selectedTickets);

        match ($action) {
            'close' => Ticket::whereIn('id', $this->selectedTickets)
                ->update(['status' => 'closed', 'closed_at' => now()]),
            'resolve' => Ticket::whereIn('id', $this->selectedTickets)
                ->update(['status' => 'resolved', 'resolved_at' => now()]),
            'assign_me' => Ticket::whereIn('id', $this->selectedTickets)
                ->update(['assigned_to' => Auth::id()]),
            default => null,
        };

        $this->selectedTickets = [];
        $this->selectAll = false;
        $this->notification()->success("{$count} ticket(s) actualizados.");
    }

    public function exportTickets()
    {
        $fileName = 'tickets-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(new TicketsExport(
            search: $this->search,
            statusFilter: $this->statusFilter,
            priorityFilter: $this->priorityFilter,
            assignedFilter: $this->assignedFilter,
            from: $this->from,
            to: $this->to,
            empresaId: (int) session('empresa', 1),
        ), $fileName);
    }

    public function openModalCreate(): void
    {
        $this->dispatch('open-modal-create-ticket');
    }

    public function openModalEdit(Ticket $ticket): void
    {
        $this->dispatch('open-modal-edit-ticket', ticketId: $ticket->id);
    }

    public function openModalDelete(Ticket $ticket): void
    {
        $this->dispatch('open-modal-delete-ticket', ticketId: $ticket->id);
    }

    private function getVisibleTicketIds(): array
    {
        return Ticket::query()
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn($q) => $q->where('priority', $this->priorityFilter))
            ->when($this->categoryFilter, fn($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->assignedFilter === 'mine', fn($q) => $q->where('assigned_to', Auth::id()))
            ->when($this->assignedFilter && $this->assignedFilter !== 'mine', fn($q) => $q->where('assigned_to', $this->assignedFilter))
            ->latest('last_activity_at')
            ->pluck('id')
            ->map(fn($id) => (string) $id)
            ->toArray();
    }
}
