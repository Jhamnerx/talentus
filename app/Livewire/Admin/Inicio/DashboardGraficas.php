<?php

namespace App\Livewire\Admin\Inicio;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Productos;
use App\Models\Clientes;
use App\Models\WorkOrder;
use App\Models\ModelosDispositivo;
use App\Enums\TicketStatus;
use App\Enums\WorkOrderStatus;
use Livewire\Component;

class DashboardGraficas extends Component
{
    public function render()
    {
        // ── Tabla: Productos con menos stock ───────────────────────────
        $productosStockBajo = Productos::with(['categoria:id,nombre', 'unit:codigo,descripcion'])
            ->where('tipo', 'producto')
            ->where('estado', 1)
            ->whereNotNull('stock')
            ->where('stock', '<=', 10)
            ->orderByRaw('CAST(stock AS SIGNED) ASC') // orden numérico (evita sort lexicográfico)
            ->select('id', 'descripcion', 'stock', 'categoria_id', 'unit_code')
            ->limit(15)
            ->get();

        // ── Tabla: Clientes con vehículos activos y suscripción ────────
        // Suscripción activa = ends_at >= hoy (o trial_ends_at >= hoy)
        $subActiva = fn($s) => $s->where(function ($q) {
            $q->where('ends_at', '>=', Carbon::now())
                ->orWhere('trial_ends_at', '>=', Carbon::now());
        });

        $clientesActivos = Clientes::withCount([
            // cuenta vehículos con estado=1 + suscripción activa
            'vehiculos as vehiculos_activos_count' => fn($q) => $q
                ->where('estado', 1)
                ->whereNull('deleted_at')
                ->whereHas('planSubscriptions', $subActiva),
        ])
            ->whereHas(
                'vehiculos',
                fn($q) => $q
                    ->where('estado', 1)
                    ->whereNull('deleted_at')
                    ->whereHas('planSubscriptions', $subActiva)
            )
            ->limit(50)
            ->get()
            ->sortByDesc('vehiculos_activos_count')
            ->take(25)
            ->values();

        // ── Tabla: Dispositivos por modelo ────────────────────────────
        $dispositivosPorModelo = ModelosDispositivo::withCount([
            'dispositivo as total',
            'dispositivo as vendidos'   => fn($q) => $q->where('estado', \App\Models\Dispositivos::VENDIDO),
            'dispositivo as en_stock'   => fn($q) => $q->where('estado', \App\Models\Dispositivos::STOCK),
        ])
            ->whereHas('dispositivo')
            ->get()
            ->sortByDesc('total')
            ->values();

        // ── Card: Tickets por estado ───────────────────────────────────
        $ticketsPorEstado = collect(TicketStatus::cases())->map(function (TicketStatus $status) {
            return [
                'estado'  => $status->label(),
                'valor'   => $status->value,
                'total'   => Ticket::where('status', $status->value)->count(),
                'color'   => $status->statusColor(),
            ];
        })->filter(fn($item) => $item['total'] > 0)->values();

        $totalTickets   = $ticketsPorEstado->sum('total');
        $ticketsVencidos = Ticket::overdue()->count();
        $ticketsEscalados = Ticket::whereIn('status', ['open', 'in_progress'])
            ->where('escalation_level', '>', 0)->count();

        // ── Card: Work Orders por estado ──────────────────────────────
        $workOrdersPorEstado = collect(WorkOrderStatus::cases())->map(function (WorkOrderStatus $status) {
            return [
                'estado' => $status->name,
                'label'  => ucfirst(str_replace('_', ' ', strtolower($status->value))),
                'total'  => WorkOrder::where('estado', $status->value)->count(),
                'color'  => $status->statusColor(),
            ];
        })->filter(fn($item) => $item['total'] > 0)->values();

        $totalWorkOrders = $workOrdersPorEstado->sum('total');

        return view('livewire.admin.inicio.dashboard-graficas', compact(
            'productosStockBajo',
            'clientesActivos',
            'dispositivosPorModelo',
            'ticketsPorEstado',
            'totalTickets',
            'ticketsVencidos',
            'ticketsEscalados',
            'workOrdersPorEstado',
            'totalWorkOrders',
        ));
    }
}
