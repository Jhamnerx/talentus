<?php

namespace App\Livewire\Admin\Tickets;

use App\Models\Ticket;
use App\Models\Clientes;
use App\Models\TicketCategory;
use App\Enums\TicketPriority;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;

    public $showModal = false;
    public $ticketId;
    public $subject = '';
    public $description = '';
    public $priority = '';
    public $customer_id;
    public $category_id;
    public $vehiculo_id;
    public $scheduled_at;

    protected $listeners = ['open-modal-edit-ticket' => 'openModal'];

    public function rules()
    {
        return [
            'subject' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'priority' => 'sometimes|required|in:' . implode(',', array_column(TicketPriority::cases(), 'value')),
            'customer_id' => 'sometimes|required|exists:clientes,id',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'vehiculo_id' => 'nullable|exists:vehiculos,id',
            'scheduled_at' => 'nullable|date',
        ];
    }

    public function render()
    {
        $customers = Clientes::active(1)->orderBy('razon_social')->get();
        $categories = TicketCategory::where('is_active', true)->orderBy('name')->get();

        return view('livewire.admin.tickets.edit', compact('customers', 'categories'));
    }

    public function openModal($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);


        $this->ticketId = $ticket->id;
        $this->subject = $ticket->subject;
        $this->description = $ticket->description;
        $this->priority = $ticket->priority->value;
        $this->customer_id = $ticket->customer_id;
        $this->category_id = $ticket->category_id;
        $this->vehiculo_id = $ticket->vehiculo_id;
        $this->scheduled_at = $ticket->scheduled_at?->format('Y-m-d H:i');

        $this->resetValidation();
        $this->showModal = true;
    }

    public function update()
    {
        $ticket = Ticket::findOrFail($this->ticketId);

        if ($this->scheduled_at === '') {
            $this->scheduled_at = null;
        }

        $data = $this->validate();
        $ticket->update($data);

        $this->showModal = false;
        $this->dispatch('update-table');
        $this->notification()->success('Ticket actualizado');
    }
}
