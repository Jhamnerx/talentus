<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function __construct() {}

    public function index()
    {
        return view('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load([
            'customer',
            'createdBy',
            'team',
            'assignedTo',
            'category',
            'messages.author',
            'attachments.uploadedBy',
            'events.actor'
        ]);

        return view('admin.tickets.show', compact('ticket'));
    }

    // Dashboard endpoints
    public function dashboardSummary(Request $request)
    {
        // Totales por estado
        $totalsByStatus = Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Totales por prioridad
        $totalsByPriority = Ticket::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        // Tickets vencidos (sin cerrar después de 7 días de última actividad)
        $overdueCount = Ticket::open()
            ->where('last_activity_at', '<', now()->subDays(7))
            ->count();

        // Tiempo promedio de primera respuesta (en minutos)
        $avgFirstResponse = Ticket::whereNotNull('first_response_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, first_response_at)) as avg_minutes')
            ->value('avg_minutes');

        // Tiempo promedio de resolución (en horas)
        $avgResolution = Ticket::whereNotNull('resolved_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
            ->value('avg_hours');

        return response()->json([
            'totals_by_status' => $totalsByStatus,
            'totals_by_priority' => $totalsByPriority,
            'overdue_count' => $overdueCount,
            'avg_first_response_time' => $avgFirstResponse ? round($avgFirstResponse, 1) . ' min' : null,
            'avg_resolution_time' => $avgResolution ? round($avgResolution, 1) . ' hrs' : null,
        ]);
    }

    public function dashboardTrends(Request $request)
    {
        $days = $request->get('days', 30);
        $startDate = now()->subDays($days)->startOfDay();

        // Tickets creados por día
        $created = Ticket::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tickets resueltos por día
        $resolved = Ticket::selectRaw('DATE(resolved_at) as date, COUNT(*) as count')
            ->whereNotNull('resolved_at')
            ->where('resolved_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Generar etiquetas de fechas
        $labels = [];
        $createdData = [];
        $resolvedData = [];

        for ($i = 0; $i < $days; $i++) {
            $date = now()->subDays($days - $i - 1)->format('Y-m-d');
            $labels[] = now()->subDays($days - $i - 1)->format('d/m');
            $createdData[] = $created->firstWhere('date', $date)?->count ?? 0;
            $resolvedData[] = $resolved->firstWhere('date', $date)?->count ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'created' => $createdData,
            'resolved' => $resolvedData,
        ]);
    }

    public function dashboardAgentPerformance(Request $request)
    {
        $agents = \App\Models\User::whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'agente']))
            ->withCount([
                'assignedTickets',
                'assignedTickets as open_tickets_count' => fn($q) => $q->open(),
                'assignedTickets as resolved_tickets_count' => fn($q) => $q->where('status', 'resolved'),
            ])
            ->having('assigned_tickets_count', '>', 0)
            ->get()
            ->map(function ($user) {
                // Calcular tiempo promedio de resolución
                $avgResolution = $user->assignedTickets()
                    ->whereNotNull('resolved_at')
                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
                    ->value('avg_hours');

                return [
                    'name' => $user->name,
                    'total_tickets' => $user->assigned_tickets_count,
                    'open_tickets' => $user->open_tickets_count,
                    'resolved_tickets' => $user->resolved_tickets_count,
                    'avg_resolution_time' => $avgResolution ? round($avgResolution, 1) . ' hrs' : null,
                ];
            });

        return response()->json(['agents' => $agents]);
    }

    public function dashboardTeamLoad(Request $request)
    {
        $teams = \App\Models\Team::active()
            ->withCount([
                'tickets',
                'tickets as open_tickets_count' => fn($q) => $q->open(),
                'tickets as overdue_tickets_count' => fn($q) => $q->open()->where('last_activity_at', '<', now()->subDays(7)),
            ])
            ->with('users:id,name')
            ->get()
            ->map(function ($team) {
                return [
                    'name' => $team->name,
                    'total_tickets' => $team->tickets_count,
                    'open_tickets' => $team->open_tickets_count,
                    'overdue_tickets' => $team->overdue_tickets_count,
                    'members_count' => $team->users->count(),
                ];
            });

        return response()->json(['teams' => $teams]);
    }
}
