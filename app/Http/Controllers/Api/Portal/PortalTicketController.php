<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Api\Portal\Concerns\ResolvesPortalCliente;
use App\Http\Controllers\Controller;
use App\Http\Resources\Portal\TicketResource;
use App\Models\Ticket;
use App\Scopes\EmpresaScope;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortalTicketController extends Controller
{
    use ResolvesPortalCliente;

    public function index(): AnonymousResourceCollection
    {
        $tickets = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->forCustomer($this->clienteId())
            ->with('category')
            ->orderByDesc('last_activity_at')
            ->paginate($this->perPage());

        return TicketResource::collection($tickets);
    }

    public function show(int $id): TicketResource
    {
        $ticket = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->forCustomer($this->clienteId())
            ->with([
                'category',
                'messages' => fn ($query) => $query->public()->with('author')->orderBy('created_at'),
            ])
            ->findOrFail($id);

        return new TicketResource($ticket);
    }
}
