<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Kpi;
use App\Models\Wig;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\Cobros;
use App\Models\Clientes;
use App\Models\WorkOrder;
use App\Models\KpiResultado;
use App\Models\Presupuestos;
use App\Models\KpiAlerta;
use App\Enums\CobroEstado;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;
use App\Enums\WorkOrderStatus;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Log;

class KpiCalculatorService
{
    protected int $empresaId;
    public Carbon $inicio;
    public Carbon $fin;

    /** Cache local de IDs de usuarios por area KPI */
    protected array $areaUserIdsCache = [];

    public function __construct()
    {
        $this->empresaId = (int) session('empresa');
        $this->inicio    = now()->startOfWeek(Carbon::MONDAY);
        $this->fin       = now()->endOfWeek(Carbon::SUNDAY);
    }

    // ===========================================================
    // CALCULO GENERAL
    // ===========================================================

    public function calcularTodos(Carbon $inicio = null, Carbon $fin = null): array
    {
        if ($inicio) $this->inicio = $inicio;
        if ($fin)    $this->fin    = $fin;

        $kpis = Kpi::where('activo', true)->get();
        $resultados = [];

        foreach ($kpis as $kpi) {
            try {
                $resultados[$kpi->slug] = $this->calcular($kpi);
            } catch (\Throwable $e) {
                Log::warning("KPI [{$kpi->slug}] error: " . $e->getMessage());
                $resultados[$kpi->slug] = $this->resultadoVacio($kpi);
            }
        }

        return $resultados;
    }

    public function calcular(Kpi $kpi, bool $persistir = true): array
    {
        if ($kpi->tipo === 'manual') {
            $ultimo = KpiResultado::where('kpi_id', $kpi->id)
                ->orderByDesc('periodo_inicio')
                ->first();
            return $ultimo ? $this->formatearResultado($kpi, $ultimo) : $this->resultadoVacio($kpi);
        }

        if (!$kpi->formula || !method_exists($this, $kpi->formula)) {
            return $this->resultadoVacio($kpi);
        }

        $valorActual  = $this->{$kpi->formula}();
        $semaforo     = $this->calcularSemaforo($valorActual, $kpi->meta, $kpi->meta_minima);
        $cumplimiento = $kpi->meta > 0 ? round(($valorActual / $kpi->meta) * 100, 1) : 0;

        if ($persistir) {
            KpiResultado::updateOrCreate(
                [
                    'kpi_id'         => $kpi->id,
                    'empresa_id'     => $this->empresaId,
                    'periodo_inicio' => $this->inicio->toDateString(),
                    'periodo_fin'    => $this->fin->toDateString(),
                ],
                [
                    'valor_actual' => $valorActual,
                    'valor_meta'   => $kpi->meta,
                    'cumplimiento' => $cumplimiento,
                    'semaforo'     => $semaforo,
                    'calculado_at' => now(),
                ]
            );

            // Crear alerta cuando el KPI cae en rojo (una por día)
            if ($semaforo === 'rojo') {
                $yaExiste = KpiAlerta::where('kpi_id', $kpi->id)
                    ->where('empresa_id', $this->empresaId)
                    ->where('resuelto', false)
                    ->whereDate('created_at', now()->toDateString())
                    ->exists();

                if (!$yaExiste) {
                    KpiAlerta::create([
                        'kpi_id'      => $kpi->id,
                        'empresa_id'  => $this->empresaId,
                        'titulo'      => "KPI en rojo: {$kpi->nombre}",
                        'descripcion' => "Valor actual: {$valorActual}{$kpi->unidad} — meta: {$kpi->meta}{$kpi->unidad} (cumplimiento: {$cumplimiento}%)",
                        'nivel'       => 'critico',
                        'resuelto'    => false,
                    ]);
                }
            }
        }

        return [
            'kpi_id'       => $kpi->id,
            'slug'         => $kpi->slug,
            'nombre'       => $kpi->nombre,
            'area'         => $kpi->area,
            'valor_actual' => $valorActual,
            'valor_meta'   => $kpi->meta,
            'unidad'       => $kpi->unidad,
            'cumplimiento' => $cumplimiento,
            'semaforo'     => $semaforo,
            'responsable'  => $kpi->responsable,
            'tipo'         => $kpi->tipo,
        ];
    }

    // ===========================================================
    // HELPERS INTERNOS
    // ===========================================================

    protected function getAreaUserIds(string $area): array
    {
        if (!array_key_exists($area, $this->areaUserIdsCache)) {
            $team = Team::withoutGlobalScope(EmpresaScope::class)
                ->where('empresa_id', $this->empresaId)
                ->where('kpi_area', $area)
                ->first();

            $this->areaUserIdsCache[$area] = $team
                ? $team->users()->pluck('users.id')->toArray()
                : [];
        }

        return $this->areaUserIdsCache[$area];
    }

    protected function calcularSemaforo(float $valor, float $meta, ?float $metaMinima): string
    {
        $umbral = $metaMinima ?? ($meta * 0.8);
        if ($valor >= $meta)   return 'verde';
        if ($valor >= $umbral) return 'amarillo';
        return 'rojo';
    }

    protected function resultadoVacio(Kpi $kpi): array
    {
        return [
            'kpi_id'       => $kpi->id,
            'slug'         => $kpi->slug,
            'nombre'       => $kpi->nombre,
            'area'         => $kpi->area,
            'valor_actual' => 0,
            'valor_meta'   => $kpi->meta,
            'unidad'       => $kpi->unidad,
            'cumplimiento' => 0,
            'semaforo'     => 'rojo',
            'responsable'  => $kpi->responsable,
            'tipo'         => $kpi->tipo,
        ];
    }

    protected function formatearResultado(Kpi $kpi, KpiResultado $resultado): array
    {
        return [
            'kpi_id'       => $kpi->id,
            'slug'         => $kpi->slug,
            'nombre'       => $kpi->nombre,
            'area'         => $kpi->area,
            'valor_actual' => (float) $resultado->valor_actual,
            'valor_meta'   => (float) $resultado->valor_meta,
            'unidad'       => $kpi->unidad,
            'cumplimiento' => (float) $resultado->cumplimiento,
            'semaforo'     => $resultado->semaforo,
            'responsable'  => $kpi->responsable,
            'tipo'         => $kpi->tipo,
        ];
    }

    // ===========================================================
    // AREA COMERCIAL
    // ===========================================================

    /** Propuestas nuevas registradas: Presupuestos creados en periodo por usuarios del area comercial. */
    public function propuestas_registradas(): float
    {
        $userIds = $this->getAreaUserIds('comercial');
        return (float) Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereBetween('created_at', [$this->inicio, $this->fin])
            ->when(!empty($userIds), fn($q) => $q->whereIn('user_id', $userIds))
            ->count();
    }

    /** Propuestas enviadas: Presupuestos marcados sent=1 actualizados en el periodo. */
    public function propuestas_enviadas(): float
    {
        $userIds = $this->getAreaUserIds('comercial');
        return (float) Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('sent', true)
            ->whereBetween('updated_at', [$this->inicio, $this->fin])
            ->when(!empty($userIds), fn($q) => $q->whereIn('user_id', $userIds))
            ->count();
    }

    /** Ventas cerradas: presupuestos convertidos a Recibo o CPE (boleta/factura) en el periodo. */
    public function ventas_cerradas(): float
    {
        $userIds = $this->getAreaUserIds('comercial');
        $base = Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->when(!empty($userIds), fn($q) => $q->whereIn('user_id', $userIds));

        $conRecibo  = (clone $base)->whereHas('recibo',   fn($q) => $q->whereBetween('created_at', [$this->inicio, $this->fin]))->count();
        $conFactura = (clone $base)->whereHas('invoice',  fn($q) => $q->whereBetween('created_at', [$this->inicio, $this->fin]))->count();
        $ambos      = (clone $base)
            ->whereHas('recibo',  fn($q) => $q->whereBetween('created_at', [$this->inicio, $this->fin]))
            ->whereHas('invoice', fn($q) => $q->whereBetween('created_at', [$this->inicio, $this->fin]))
            ->count();

        return (float) ($conRecibo + $conFactura - $ambos);
    }

    /** % OT completas al primer envio: presupuestos convertidos con OT asociada FINALIZADA. */
    public function ot_completas_primer_envio_pct(): float
    {
        $userIds = $this->getAreaUserIds('comercial');
        $baseConvertida = Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->when(!empty($userIds), fn($q) => $q->whereIn('user_id', $userIds))
            ->where(function ($q) {
                $q->whereHas('recibo',  fn($r) => $r->whereBetween('created_at', [$this->inicio, $this->fin]))
                    ->orWhereHas('invoice', fn($v) => $v->whereBetween('created_at', [$this->inicio, $this->fin]));
            })
            ->whereHas('workOrders');

        $total = $baseConvertida->count();
        if ($total === 0) return 100.0;

        $otFinalizadas = (clone $baseConvertida)
            ->whereHas('workOrders', fn($q) => $q->where('estado', WorkOrderStatus::FINALIZADO))
            ->count();

        return round(($otFinalizadas / $total) * 100, 1);
    }

    /** % Ventas con adelanto validado: presupuestos convertidos con adelanto > 0. */
    public function ventas_con_adelanto_pct(): float
    {
        $userIds = $this->getAreaUserIds('comercial');
        $base = Presupuestos::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->when(!empty($userIds), fn($q) => $q->whereIn('user_id', $userIds))
            ->where(function ($q) {
                $q->whereHas('recibo',  fn($r) => $r->whereBetween('created_at', [$this->inicio, $this->fin]))
                    ->orWhereHas('invoice', fn($v) => $v->whereBetween('created_at', [$this->inicio, $this->fin]));
            });

        $total = $base->count();
        if ($total === 0) return 100.0;

        $conAdelanto = (clone $base)->where('adelanto', '>', 0)->count();
        return round(($conAdelanto / $total) * 100, 1);
    }

    // ===========================================================
    // AREA OPERACIONES
    // ===========================================================

    /** Instalaciones realizadas: OTs de tipo instalacion finalizadas en el periodo. */
    public function instalaciones_realizadas(): float
    {
        return (float) WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', WorkOrderStatus::FINALIZADO)
            ->whereHas('tipo', fn($q) => $q->where('nombre', 'like', '%instalac%'))
            ->whereBetween('fecha_finalizacion', [$this->inicio, $this->fin])
            ->count();
    }

    /** % Instalaciones a tiempo: finalizadas el mismo dia que fecha_programada. */
    public function instalaciones_a_tiempo_pct(): float
    {
        $base = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', WorkOrderStatus::FINALIZADO)
            ->whereHas('tipo', fn($q) => $q->where('nombre', 'like', '%instalac%'))
            ->whereNotNull('fecha_programada')
            ->whereBetween('fecha_finalizacion', [$this->inicio, $this->fin]);

        $total = $base->count();
        if ($total === 0) return 100.0;

        $aTiempo = (clone $base)->whereRaw('DATE(fecha_finalizacion) = DATE(fecha_programada)')->count();
        return round(($aTiempo / $total) * 100, 1);
    }

    /**
     * % Instalaciones sin retrabajo.
     * OTs instalacion finalizadas sin nueva OT de mantenimiento/revision
     * para el mismo vehiculo en los 30 dias posteriores.
     * Usa subquery SQL para evitar N+1.
     */
    public function instalaciones_sin_retrabajo_pct(): float
    {
        $total = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', WorkOrderStatus::FINALIZADO)
            ->whereHas('tipo', fn($q) => $q->where('nombre', 'like', '%instalac%'))
            ->whereBetween('fecha_finalizacion', [$this->inicio, $this->fin])
            ->whereNotNull('vehiculo_id')
            ->count();

        if ($total === 0) return 100.0;

        // Contar instalaciones SIN retrabajo usando subquery EXISTS
        $sinRetrabajo = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->from('work_orders as ot1')
            ->where('ot1.empresa_id', $this->empresaId)
            ->where('ot1.estado', WorkOrderStatus::FINALIZADO->value)
            ->whereHas('tipo', fn($q) => $q->where('nombre', 'like', '%instalac%'))
            ->whereBetween('ot1.fecha_finalizacion', [$this->inicio, $this->fin])
            ->whereNotNull('ot1.vehiculo_id')
            ->whereNotExists(function ($sub) {
                $sub->from('work_orders as ot2')
                    ->join('work_order_types as wot', 'wot.id', '=', 'ot2.work_order_type_id')
                    ->whereColumn('ot2.vehiculo_id', 'ot1.vehiculo_id')
                    ->whereColumn('ot2.id', '!=', 'ot1.id')
                    ->where('ot2.empresa_id', $this->empresaId)
                    ->where(function ($q) {
                        $q->where('wot.nombre', 'like', '%manteni%')
                            ->orWhere('wot.nombre', 'like', '%revision%');
                    })
                    ->whereRaw('ot2.created_at > ot1.fecha_finalizacion')
                    ->whereRaw('ot2.created_at <= DATE_ADD(ot1.fecha_finalizacion, INTERVAL 30 DAY)');
            })
            ->count();

        return round(($sinRetrabajo / $total) * 100, 1);
    }

    /** % Unidades activas dentro del plazo: Cobros ACTIVOS con fecha_vencimiento >= hoy. */
    public function unidades_activas_plazo_pct(): float
    {
        $total = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->count();

        if ($total === 0) return 100.0;

        $enPlazo = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->where('fecha_vencimiento', '>=', now()->toDateString())
            ->count();

        return round(($enPlazo / $total) * 100, 1);
    }

    // ===========================================================
    // AREA ADMINISTRACION
    // ===========================================================

    /** % Expedientes completos: clientes activos con al menos un contrato registrado. */
    public function expedientes_completos_pct(): float
    {
        $total = Clientes::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', true)
            ->count();

        if ($total === 0) return 100.0;

        $conContrato = Clientes::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', true)
            ->whereHas('contratos')
            ->count();

        return round(($conContrato / $total) * 100, 1);
    }

    /**
     * % Comprobantes emitidos dentro de 24h.
     * OTs finalizadas (con presupuesto_id) cuyo recibo/factura se emitio
     * dentro de las 24h posteriores a la finalizacion de la OT.
     */
    public function comprobantes_24h_pct(): float
    {
        $ots = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', WorkOrderStatus::FINALIZADO)
            ->whereNotNull('presupuesto_id')
            ->whereBetween('fecha_finalizacion', [$this->inicio, $this->fin])
            ->with(['presupuesto.recibo', 'presupuesto.invoice'])
            ->get(['id', 'presupuesto_id', 'fecha_finalizacion']);

        $total = $ots->count();
        if ($total === 0) return 100.0;

        $dentro24h = $ots->filter(function ($ot) {
            $pres = $ot->presupuesto;
            if (!$pres) return false;
            $comprobante = $pres->recibo ?? $pres->invoice;
            if (!$comprobante) return false;
            return $comprobante->created_at <= $ot->fecha_finalizacion->addHours(24);
        })->count();

        return round(($dentro24h / $total) * 100, 1);
    }

    /** % Cobranza al dia: Cobros ACTIVOS con fecha_vencimiento >= hoy. */
    public function cobranza_al_dia_pct(): float
    {
        $total = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->count();

        if ($total === 0) return 100.0;

        $alDia = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->where(function ($q) {
                $q->whereNull('fecha_vencimiento')
                    ->orWhere('fecha_vencimiento', '>=', now()->toDateString());
            })
            ->count();

        return round(($alDia / $total) * 100, 1);
    }

    // ===========================================================
    // AREA POST VENTA & RECLAMOS
    // ===========================================================

    /**
     * % Reclamos críticos atendidos en < 2h.
     * Denominador = TODOS los tickets HIGH/URGENT del período.
     * Los que no tienen first_response_at cuentan como SLA fallido.
     */
    public function reclamos_atendidos_2h_pct(): float
    {
        $total = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereIn('priority', [TicketPriority::HIGH->value, TicketPriority::URGENT->value])
            ->whereBetween('created_at', [$this->inicio, $this->fin])
            ->count();

        if ($total === 0) return 100.0;

        $dentro2h = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereIn('priority', [TicketPriority::HIGH->value, TicketPriority::URGENT->value])
            ->whereNotNull('first_response_at')
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, first_response_at) <= 2')
            ->whereBetween('created_at', [$this->inicio, $this->fin])
            ->count();

        return round(($dentro2h / $total) * 100, 1);
    }

    /** Reclamos criticos sin resolver > 24h (conteo — meta = 0). */
    public function reclamos_criticos_sin_resolver_24h(): float
    {
        return (float) Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereIn('priority', [TicketPriority::HIGH->value, TicketPriority::URGENT->value])
            ->whereNotIn('status', [TicketStatus::RESOLVED->value, TicketStatus::CLOSED->value])
            ->where('created_at', '<=', now()->subHours(24))
            ->count();
    }

    /** Calificación promedio de órdenes de trabajo finalizadas (escala 1-5). */
    public function visitas_tecnicas_satisfaccion(): float
    {
        $avg = WorkOrder::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', WorkOrderStatus::FINALIZADO)
            ->whereNotNull('calificacion_cliente')
            ->whereBetween('fecha_finalizacion', [$this->inicio, $this->fin])
            ->avg('calificacion_cliente');

        return round($avg ?? 5.0, 1);
    }

    // ===========================================================
    // AREA MONITOREO GPS
    // ===========================================================

    /**
     * % Unidades inactivas GPS con ticket abierto el mismo dia.
     * Consulta GpsWox categoria "critical" (>24h sin transmitir).
     */
    public function unidades_inactivas_con_ticket_pct(): float
    {
        try {
            $gps      = app(GpsWoxService::class);
            $inactivos = $gps->getDevicesByTransmissionCategory('critical');
            $total     = count($inactivos);

            if ($total === 0) return 100.0;

            $conTicket = 0;
            $hoy = now()->toDateString();

            foreach ($inactivos as $device) {
                $placa = $device['plate_number'] ?? null;
                if (!$placa) continue;

                $vehiculoId = \App\Models\Vehiculos::withoutGlobalScope(EmpresaScope::class)
                    ->where('empresa_id', $this->empresaId)
                    ->where('placa', $placa)
                    ->value('id');

                if (!$vehiculoId) continue;

                if (Ticket::withoutGlobalScope(EmpresaScope::class)
                    ->where('empresa_id', $this->empresaId)
                    ->where('vehiculo_id', $vehiculoId)
                    ->whereDate('created_at', $hoy)
                    ->exists()
                ) {
                    $conTicket++;
                }
            }

            return $total > 0 ? round(($conTicket / $total) * 100, 1) : 100.0;
        } catch (\Throwable $e) {
            Log::warning('KPI Monitoreo GPS: no se pudo consultar GpsWox', ['error' => $e->getMessage()]);
            return 100.0; // Sin datos GPS asumimos que el KPI no falla por error de API
        }
    }

    /** % Tickets de fallas resueltos dentro del SLA (resolved_at <= due_at). */
    public function tickets_fallas_sla_pct(): float
    {
        $total = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereIn('status', [TicketStatus::RESOLVED->value, TicketStatus::CLOSED->value])
            ->whereNotNull('resolved_at')
            ->whereNotNull('due_at')
            ->whereBetween('resolved_at', [$this->inicio, $this->fin])
            ->count();

        if ($total === 0) return 100.0;

        $dentraSla = Ticket::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->whereIn('status', [TicketStatus::RESOLVED->value, TicketStatus::CLOSED->value])
            ->whereNotNull('resolved_at')
            ->whereNotNull('due_at')
            ->whereColumn('resolved_at', '<=', 'due_at')
            ->whereBetween('resolved_at', [$this->inicio, $this->fin])
            ->count();

        return round(($dentraSla / $total) * 100, 1);
    }

    // ===========================================================
    // WIGs
    // ===========================================================

    public function calcularWigs(): array
    {
        $wigs = Wig::where('estado', 'activo')->orderBy('orden')->get();
        $resultado = [];

        foreach ($wigs as $wig) {
            if ($wig->formula && method_exists($this, $wig->formula)) {
                try {
                    $valor = $this->{$wig->formula}();
                    $wig->valor_actual = $valor;
                    $wig->save();
                } catch (\Throwable $e) {
                    Log::warning("WIG [{$wig->titulo}] error: " . $e->getMessage());
                }
            }

            $porcentaje = $wig->meta > 0 ? round(($wig->valor_actual / $wig->meta) * 100, 1) : 0;
            $semaforo   = $this->calcularSemaforo($wig->valor_actual, $wig->meta, $wig->meta * 0.80);

            $resultado[] = [
                'id'           => $wig->id,
                'titulo'       => $wig->titulo,
                'descripcion'  => $wig->descripcion,
                'meta'         => (float) $wig->meta,
                'valor_actual' => (float) $wig->valor_actual,
                'unidad'       => $wig->unidad,
                'responsable'  => $wig->responsable,
                'porcentaje'   => $porcentaje,
                'semaforo'     => $semaforo,
            ];
        }

        return $resultado;
    }

    public function wig_instalaciones_sin_retrabajo(): float
    {
        return $this->instalaciones_sin_retrabajo_pct();
    }

    public function wig_unidades_activas_plazo(): float
    {
        return $this->unidades_activas_plazo_pct();
    }

    public function wig_clientes_plataforma_7dias(): float
    {
        $total = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->count();

        if ($total === 0) return 100.0;

        $vigentes = Cobros::withoutGlobalScope(EmpresaScope::class)
            ->where('empresa_id', $this->empresaId)
            ->where('estado', CobroEstado::ACTIVO)
            ->where('fecha_vencimiento', '>=', now()->toDateString())
            ->count();

        return round(($vigentes / $total) * 100, 1);
    }

    public function wig_renovacion_contratos(): float
    {
        return $this->expedientes_completos_pct();
    }
}
