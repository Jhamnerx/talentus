<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketCategory;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use App\Mail\TicketCustomerMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $subject = '';
    public $description = '';
    public $priority = 'medium';
    public $customer_id;
    public $category_id;
    public $assigned_to;
    public $vehiculo_id;

    protected $listeners = ['open-modal-create-ticket' => 'openModal'];

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:' . implode(',', array_column(TicketPriority::cases(), 'value')),
            'customer_id' => 'required|exists:clientes,id',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
        ];
    }

    protected $messages = [
        'subject.required' => 'El asunto es obligatorio',
        'description.required' => 'La descripción es obligatoria',
        'customer_id.required' => 'El cliente es obligatorio',
        'customer_id.exists' => 'El cliente seleccionado no existe',
    ];

    public function render()
    {
        $categories = TicketCategory::where('is_active', true)->orderBy('name')->get();
        $users = User::whereHas('roles', fn($q) => $q->whereNotIn('name', ['finanzas', 'tecnico']))
            ->orderBy('name')->get();

        return view('livewire.admin.tickets.create', compact('categories', 'users'));
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['subject', 'description', 'priority', 'customer_id', 'category_id', 'vehiculo_id']);
        $this->assigned_to = Auth::user()->id;
        $this->showModal = true;
    }

    public function save()
    {
        $data = $this->validate();
        $data['status'] = TicketStatus::NEW->value;
        $data['created_by'] = Auth::user()->id;
        if (empty($data['assigned_to'])) {
            $data['assigned_to'] = Auth::user()->id;
        }

        $ticket = Ticket::with('customer')->find(Ticket::create($data)->id);

        if ($ticket->customer?->email) {
            try {
                Mail::to($ticket->customer->email)->queue(
                    new TicketCustomerMail($ticket, 'Tu ticket ha sido recibido. Nuestro equipo de soporte lo atenderá a la brevedad.', 'created')
                );
            } catch (\Throwable) {
            }
        }

        $this->showModal = false;
        $this->dispatch('update-table');
        $this->notification()->success('Ticket creado', 'Código: ' . $ticket->code);
    }
}
