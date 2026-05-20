<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        private string $search = '',
        private string $statusFilter = '',
        private string $priorityFilter = '',
        private string $assignedFilter = '',
        private string $from = '',
        private string $to = '',
        private int $empresaId = 0,
    ) {}

    public function query(): Builder
    {
        return Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->with(['customer', 'assignedTo', 'category', 'createdBy'])
            ->when($this->search, fn($q) => $q->where(function ($sub) {
                $sub->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%');
            }))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn($q) => $q->where('priority', $this->priorityFilter))
            ->when($this->assignedFilter && $this->assignedFilter !== 'mine', fn($q) => $q->where('assigned_to', $this->assignedFilter))
            ->when($this->from && $this->to, fn($q) => $q->whereBetween('created_at', [
                $this->from . ' 00:00:00',
                $this->to . ' 23:59:59',
            ]))
            ->latest('last_activity_at');
    }

    public function headings(): array
    {
        return [
            'Código',
            'Asunto',
            'Cliente',
            'Estado',
            'Prioridad',
            'Categoría',
            'Asignado a',
            'Creado por',
            'Creado',
            'Vence SLA',
            'Respuesta inicial',
            'Resuelto',
            'Cerrado',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->code,
            $ticket->subject,
            $ticket->customer->razon_social ?? '-',
            $ticket->status->label(),
            $ticket->priority->label(),
            $ticket->category->name ?? '-',
            $ticket->assignedTo->name ?? '-',
            $ticket->createdBy->name ?? '-',
            $ticket->created_at->format('d/m/Y H:i'),
            $ticket->due_at?->format('d/m/Y H:i') ?? '-',
            $ticket->first_response_at?->format('d/m/Y H:i') ?? '-',
            $ticket->resolved_at?->format('d/m/Y H:i') ?? '-',
            $ticket->closed_at?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
