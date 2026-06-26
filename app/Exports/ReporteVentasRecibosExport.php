<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Ventas;
use App\Models\Recibos;
use App\Models\BankAccount;
use App\Exports\ReporteResumenSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteVentasRecibosExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(
        public readonly string  $contexto,           // ventas | recibos | ambos
        public readonly string  $agrupacion,          // mensual | semanal
        public readonly string  $fecha_inicio,
        public readonly string  $fecha_fin,
        public readonly ?string $estado,
        public readonly ?string $tipo_comprobante_id,
        public readonly mixed   $cliente_id
    ) {}

    // ─── WithMultipleSheets ──────────────────────────────────────────────

    public function sheets(): array
    {
        $items = $this->fetchItems();

        // Maximo de pagos en cualquier documento — define las columnas dinamicas
        $maxPagos = (int) max(1, $items->max(fn($r) => count($r['_payments'] ?? [])) ?? 0);

        $sheets = [];

        // Primera hoja: resumen de totales
        $sheets[] = new ReporteResumenSheet($this->buildResumen($items), $this->contexto);

        // Hojas de detalle por periodo
        if ($items->isEmpty()) {
            $sheets[] = new ReportePeriodoSheet('Sin datos', collect(), $this->contexto, $maxPagos);
        } else {
            $periodos = $items
                ->groupBy('_group')
                ->sortKeys()
                ->map(fn($grupo, $label) => new ReportePeriodoSheet($label, $grupo, $this->contexto, $maxPagos))
                ->values()
                ->toArray();

            $sheets = array_merge($sheets, $periodos);
        }

        return $sheets;
    }

    // ─── Query principal ─────────────────────────────────────────────────

    private function fetchItems(): Collection
    {
        $items    = collect();
        $hoy      = Carbon::today();

        if (in_array($this->contexto, ['ventas', 'ambos'])) {
            Ventas::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->with(['cliente', 'user', 'payments.paymentMethod', 'payments.destination', 'notaCredito.sustento', 'envioResumen'])
                ->when(
                    $this->tipo_comprobante_id,
                    fn($q) => $q->where('tipo_comprobante_id', $this->tipo_comprobante_id)
                )
                ->when(
                    $this->cliente_id,
                    fn($q) => $q->where('cliente_id', $this->cliente_id)
                )
                ->orderBy('created_at')
                ->get()
                ->each(function ($v) use (&$items, $hoy) {
                    $isAnulada   = !is_null($v->id_baja);
                    $hasNC       = !is_null($v->notaCredito);
                    $observacion = $isAnulada ? 'ANULADA' : ($hasNC ? 'CON NOTA CREDITO' : '');

                    // Datos de comunicación de baja (solo si está anulada)
                    $numBaja    = '';
                    $motivoBaja = '';
                    if ($isAnulada && $v->envioResumen) {
                        // Extraer serie-correlativo de nombre_xml quitando el RUC al inicio
                        $numBaja    = $v->envioResumen->nombre_xml
                            ? preg_replace('/^\d+-/', '', $v->envioResumen->nombre_xml)
                            : '';
                        $motivoBaja = $v->envioResumen->fe_mensaje_sunat ?? '';
                    }

                    // Datos de nota de crédito (solo si tiene NC)
                    $ncSerie        = '';
                    $ncEstado       = '';
                    $ncSustento     = '';
                    $ncMensajeSunat = '';
                    if ($hasNC && $v->notaCredito) {
                        $nc             = $v->notaCredito;
                        $ncSerie        = $nc->serie_correlativo ?? '';
                        $ncEstado       = $nc->estado_texto ?? '';
                        $ncSustento     = $nc->sustento_texto
                            ?? $nc->sustento?->descripcion
                            ?? '';
                        $ncMensajeSunat = $nc->fe_mensaje_sunat ?? '';
                    }

                    // Aplicar filtro de estado solo a registros activos (no anuladas/NC)
                    if (
                        !$isAnulada && !$hasNC
                        && $this->estado
                        && $this->estado !== 'Todos'
                        && $v->pago_estado !== $this->estado
                    ) {
                        return;
                    }

                    $fecha       = Carbon::parse($v->fecha_emision);
                    $esPaid      = (!$isAnulada && !$hasNC) && $v->pago_estado === 'PAID';
                    $vto         = $v->fecha_vencimiento ? Carbon::parse($v->fecha_vencimiento) : null;
                    $diasRetraso = (!$esPaid && !$isAnulada && !$hasNC && $vto && $vto->lt($hoy))
                        ? (int) $vto->diffInDays($hoy)
                        : 0;

                    $esPen      = strtoupper($v->divisa ?? 'PEN') === 'PEN';
                    $total      = (float) $v->total;

                    // Monto realmente cobrado segun los pagos registrados (fuente de verdad)
                    $pagado     = (!$isAnulada && !$hasNC) ? (float) $v->payments->sum('monto') : 0.0;
                    $saldo      = round($total - $pagado, 2);
                    $estadoPago = $isAnulada ? 'ANULADO'
                        : ($hasNC ? 'CON NC'
                        : (round($pagado, 2) >= round($total, 2) ? 'PAGADO'
                        : ($pagado > 0 ? 'PARCIAL' : 'PENDIENTE')));
                    $abonadoCol = ($isAnulada || $hasNC) ? '' : $pagado;
                    $saldoCol   = ($isAnulada || $hasNC) ? '' : $saldo;
                    $sortPrefix = ($isAnulada || $hasNC) ? 'ZZZZ_' : '';

                    $row = [
                        '_group'    => $this->getGroupLabel($fecha),
                        '_sort'     => $sortPrefix . ($v->created_at?->format('Y-m-d H:i:s') ?? $fecha->format('Y-m-d')),
                        '_payments' => $this->prepararPagos($v->payments),
                    ];

                    $financiero = [
                        (float) ($v->op_gravadas   ?? 0),
                        (float) ($v->op_exoneradas ?? 0),
                        (float) ($v->op_inafectas  ?? 0),
                        (float) ($v->sub_total     ?? 0),
                        (float) ($v->igv           ?? 0),
                        $total,
                        $esPen ? 'SOLES' : 'DOLARES',
                    ];

                    if ($this->contexto === 'ventas') {
                        $row['_suffix'] = [
                            $v->user?->name ?? '',
                            $v->fe_mensaje_sunat ?? '',
                            $observacion,
                            $numBaja,
                            $motivoBaja,
                            $ncSerie,
                            $ncSustento,
                            $ncEstado,
                            $ncMensajeSunat,
                        ];
                        $row += array_merge([
                            $fecha->format('d/m/Y'),
                            $v->serie_correlativo ?? '',
                            $v->cliente?->razon_social ?? '',
                            $v->cliente?->numero_documento ?? '',
                            $v->forma_pago ?? '',
                        ], $financiero, [
                            $estadoPago,
                            $abonadoCol,
                            $saldoCol,
                            $vto?->format('d/m/Y') ?? '',
                            $diasRetraso > 0 ? $diasRetraso : '',
                        ]);
                    } else { // ambos
                        $row['_suffix'] = [$observacion, $numBaja, $motivoBaja, $ncSerie, $ncSustento, $ncEstado, $ncMensajeSunat];
                        $row += array_merge([
                            'VENTA',
                            $fecha->format('d/m/Y'),
                            $v->serie_correlativo ?? '',
                            $v->cliente?->razon_social ?? '',
                            $v->cliente?->numero_documento ?? '',
                            $v->forma_pago ?? '',
                        ], $financiero, [
                            $estadoPago,
                            $abonadoCol,
                            $saldoCol,
                            $vto?->format('d/m/Y') ?? '',
                            $diasRetraso > 0 ? $diasRetraso : '',
                        ]);
                    }

                    $items->push($row);
                });
        }

        if (in_array($this->contexto, ['recibos', 'ambos'])) {
            Recibos::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->with(['clientes', 'payments.paymentMethod', 'payments.destination'])
                ->when(
                    $this->estado && $this->estado !== 'Todos',
                    fn($q) => $q->where('pago_estado', $this->estado)
                )
                ->when(
                    $this->cliente_id,
                    fn($q) => $q->where('clientes_id', $this->cliente_id)
                )
                ->orderBy('created_at')
                ->get()
                ->each(function ($r) use (&$items) {
                    $fecha     = Carbon::parse($r->fecha_emision);
                    $esPen     = strtoupper($r->divisa ?? 'PEN') === 'PEN';
                    $total     = (float) $r->total;

                    // Monto cobrado y fecha del ultimo pago segun los pagos reales (fuente de verdad)
                    $pagado    = (float) $r->payments->sum('monto');
                    $saldo     = round($total - $pagado, 2);
                    $estadoPago = round($pagado, 2) >= round($total, 2) ? 'PAGADO'
                        : ($pagado > 0 ? 'PARCIAL' : 'PENDIENTE');

                    $ultimoPago = $r->payments
                        ->sortByDesc(fn($p) => $p->fecha)
                        ->first();
                    $fechaPago = $ultimoPago?->fecha
                        ? Carbon::parse($ultimoPago->fecha)
                        : ($r->fecha_pago ? Carbon::parse($r->fecha_pago) : null);

                    $row = [
                        '_group'    => $this->getGroupLabel($fecha),
                        '_sort'     => $r->created_at?->format('Y-m-d H:i:s') ?? $fecha->format('Y-m-d'),
                        '_payments' => $this->prepararPagos($r->payments),
                    ];

                    if ($this->contexto === 'recibos') {
                        $row['_suffix'] = [];
                        $row += [
                            $fecha->format('d/m/Y'),
                            ($r->serie ?? '') . '-' . ($r->numero ?? ''),
                            $r->clientes?->razon_social ?? '',
                            $r->clientes?->numero_documento ?? '',
                            $r->tipo_venta ?? '',
                            $esPen  ? $total : 0.00,
                            !$esPen ? $total : 0.00,
                            $estadoPago,
                            $pagado,
                            $saldo,
                            $fechaPago?->format('d/m/Y') ?? '',
                            '',  // recibos no tienen dias de retraso
                        ];
                    } else { // ambos
                        // Recibos en contexto ambos: campos financieros vacios para mantener columnas alineadas
                        $row['_suffix'] = ['', '', ''];  // OBSERVACION, N° BAJA, MOTIVO BAJA
                        $row += [
                            'RECIBO',
                            $fecha->format('d/m/Y'),
                            ($r->serie ?? '') . '-' . ($r->numero ?? ''),
                            $r->clientes?->razon_social ?? '',
                            $r->clientes?->numero_documento ?? '',
                            $r->tipo_venta ?? '',
                            '',  // op_gravadas
                            '',  // op_exoneradas
                            '',  // op_inafectas
                            '',  // sub_total
                            '',  // igv
                            $total,
                            $esPen ? 'SOLES' : 'DOLARES',
                            $estadoPago,
                            $pagado,
                            $saldo,
                            $fechaPago?->format('d/m/Y') ?? '',
                            '',  // dias de retraso
                        ];
                    }

                    $items->push($row);
                });
        }

        return $items->sortBy('_sort')->values();
    }

    // ─── Resumen consolidado para la hoja 1 ─────────────────────────────

    private function buildResumen(Collection $items): array
    {
        // Reconstruir totales desde los registros ya cargados en fetchItems
        // Para el resumen necesitamos re-consultar con eager loading limpio
        $hoy = Carbon::today();

        $resumen = [
            'facturado_pen'     => 0.0,
            'facturado_usd'     => 0.0,
            'cobrado_pen'       => 0.0,
            'cobrado_usd'       => 0.0,
            'por_cobrar_pen'    => 0.0,
            'por_cobrar_usd'    => 0.0,
            'vencido_pen'       => 0.0,
            'vencido_usd'       => 0.0,
            'destinos'          => [],   // ['Caja General' => ['pen' => x, 'usd' => x], ...]
            'metodos'           => [],   // ['Yape' => ['pen' => x, 'usd' => x], ...]
            'por_cobrar_docs'   => [],   // detalle de documentos pendientes
            'anuladas_pen'      => 0.0,
            'anuladas_usd'      => 0.0,
            'anuladas_count'    => 0,
            'nc_pen'            => 0.0,
            'nc_usd'            => 0.0,
            'nc_count'          => 0,
        ];

        if (in_array($this->contexto, ['ventas', 'ambos'])) {
            // Ventas activas (excluye anuladas y con nota de crédito)
            Ventas::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->whereNull('id_baja')
                ->whereDoesntHave('notaCredito')
                ->with(['cliente', 'payments.paymentMethod', 'payments.destination'])
                ->when($this->tipo_comprobante_id, fn($q) => $q->where('tipo_comprobante_id', $this->tipo_comprobante_id))
                ->when($this->cliente_id, fn($q) => $q->where('cliente_id', $this->cliente_id))
                ->get()
                ->each(function ($v) use (&$resumen, $hoy) {
                    $esPen  = strtoupper($v->divisa ?? 'PEN') === 'PEN';
                    $total  = (float) $v->total;

                    // Facturado total
                    $esPen ? $resumen['facturado_pen'] += $total : $resumen['facturado_usd'] += $total;

                    // Cobrado: sumar SIEMPRE los pagos reales (incluye abonos parciales)
                    $pagado = 0.0;
                    foreach ($v->payments as $p) {
                        $monto = (float) $p->monto;
                        $div   = strtoupper($p->divisa ?? 'PEN') === 'PEN';
                        $div ? $resumen['cobrado_pen'] += $monto : $resumen['cobrado_usd'] += $monto;
                        $pagado += $monto;

                        // Por destino (omitir destinos sin label)
                        $dest = $this->destinoLabel($p);
                        if ($dest !== '') {
                            $resumen['destinos'][$dest] ??= ['pen' => 0.0, 'usd' => 0.0];
                            $div
                                ? $resumen['destinos'][$dest]['pen'] += $monto
                                : $resumen['destinos'][$dest]['usd'] += $monto;
                        }

                        // Por método
                        $met = $p->paymentMethod?->description ?? 'Sin método';
                        $resumen['metodos'][$met] ??= ['pen' => 0.0, 'usd' => 0.0];
                        $div
                            ? $resumen['metodos'][$met]['pen'] += $monto
                            : $resumen['metodos'][$met]['usd'] += $monto;
                    }

                    // Saldo pendiente (total - abonado). Solo lo no cobrado va a por cobrar.
                    $saldo = round($total - $pagado, 2);
                    if ($saldo > 0) {
                        $esPen ? $resumen['por_cobrar_pen'] += $saldo : $resumen['por_cobrar_usd'] += $saldo;

                        $vto         = $v->fecha_vencimiento ? Carbon::parse($v->fecha_vencimiento) : null;
                        $diasRetraso = ($vto && $vto->lt($hoy)) ? (int) $vto->diffInDays($hoy) : 0;

                        if ($diasRetraso > 0) {
                            $esPen ? $resumen['vencido_pen'] += $saldo : $resumen['vencido_usd'] += $saldo;
                        }

                        $resumen['por_cobrar_docs'][] = [
                            'tipo'         => 'VENTA',
                            'documento'    => $v->serie_correlativo ?? '',
                            'cliente'      => $v->cliente?->razon_social ?? '',
                            'total_pen'    => $esPen ? $saldo : 0,
                            'total_usd'    => !$esPen ? $saldo : 0,
                            'vto'          => $vto?->format('d/m/Y') ?? '',
                            'dias_retraso' => $diasRetraso,
                        ];
                    }
                });

            // Totales de ventas anuladas (id_baja IS NOT NULL)
            $ventasAnuladas = Ventas::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->whereNotNull('id_baja')
                ->when($this->tipo_comprobante_id, fn($q) => $q->where('tipo_comprobante_id', $this->tipo_comprobante_id))
                ->when($this->cliente_id, fn($q) => $q->where('cliente_id', $this->cliente_id))
                ->get();
            foreach ($ventasAnuladas as $v) {
                $esPen = strtoupper($v->divisa ?? 'PEN') === 'PEN';
                $esPen
                    ? $resumen['anuladas_pen'] += (float) $v->total
                    : $resumen['anuladas_usd'] += (float) $v->total;
            }
            $resumen['anuladas_count'] = $ventasAnuladas->count();

            // Totales de ventas con nota de crédito
            $ventasConNc = Ventas::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->whereNull('id_baja')
                ->whereHas('notaCredito')
                ->when($this->tipo_comprobante_id, fn($q) => $q->where('tipo_comprobante_id', $this->tipo_comprobante_id))
                ->when($this->cliente_id, fn($q) => $q->where('cliente_id', $this->cliente_id))
                ->get();
            foreach ($ventasConNc as $v) {
                $esPen = strtoupper($v->divisa ?? 'PEN') === 'PEN';
                $esPen
                    ? $resumen['nc_pen'] += (float) $v->total
                    : $resumen['nc_usd'] += (float) $v->total;
            }
            $resumen['nc_count'] = $ventasConNc->count();
        }

        if (in_array($this->contexto, ['recibos', 'ambos'])) {
            Recibos::query()
                ->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin])
                ->where('estado', '!=', 'BORRADOR')
                ->with(['clientes', 'payments.paymentMethod', 'payments.destination'])
                ->when($this->cliente_id, fn($q) => $q->where('clientes_id', $this->cliente_id))
                ->get()
                ->each(function ($r) use (&$resumen) {
                    $esPen  = strtoupper($r->divisa ?? 'PEN') === 'PEN';
                    $total  = (float) $r->total;

                    $esPen ? $resumen['facturado_pen'] += $total : $resumen['facturado_usd'] += $total;

                    // Cobrado: sumar SIEMPRE los pagos reales (incluye abonos parciales)
                    $pagado = 0.0;
                    foreach ($r->payments as $p) {
                        $monto = (float) $p->monto;
                        $div   = strtoupper($p->divisa ?? 'PEN') === 'PEN';
                        $div ? $resumen['cobrado_pen'] += $monto : $resumen['cobrado_usd'] += $monto;
                        $pagado += $monto;

                        $dest = $this->destinoLabel($p);
                        if ($dest !== '') {
                            $resumen['destinos'][$dest] ??= ['pen' => 0.0, 'usd' => 0.0];
                            $div
                                ? $resumen['destinos'][$dest]['pen'] += $monto
                                : $resumen['destinos'][$dest]['usd'] += $monto;
                        }

                        $met = $p->paymentMethod?->description ?? 'Sin método';
                        $resumen['metodos'][$met] ??= ['pen' => 0.0, 'usd' => 0.0];
                        $div
                            ? $resumen['metodos'][$met]['pen'] += $monto
                            : $resumen['metodos'][$met]['usd'] += $monto;
                    }

                    // Saldo pendiente (total - abonado). Solo lo no cobrado va a por cobrar.
                    $saldo = round($total - $pagado, 2);
                    if ($saldo > 0) {
                        $esPen ? $resumen['por_cobrar_pen'] += $saldo : $resumen['por_cobrar_usd'] += $saldo;

                        $resumen['por_cobrar_docs'][] = [
                            'tipo'        => 'RECIBO',
                            'documento'   => ($r->serie ?? '') . '-' . ($r->numero ?? ''),
                            'cliente'     => $r->clientes?->razon_social ?? '',
                            'total_pen'   => $esPen ? $saldo : 0,
                            'total_usd'   => !$esPen ? $saldo : 0,
                            'vto'         => '',
                            'dias_retraso' => 0,
                        ];
                    }
                });
        }

        return $resumen;
    }

    // ─── Helpers ─────────────────────────────────────────────────────────

    private function prepararPagos($payments): array
    {
        return $payments->map(function ($p) {
            $destino = $this->destinoLabel($p);
            $metodo  = $p->paymentMethod?->description ?? '';
            $ref     = $p->numero_operacion ?? $p->numero ?? '';
            $monto   = number_format((float) $p->monto, 2);

            $label    = implode(' / ', array_filter([$destino, $metodo]));
            $montoRef = $ref ? "{$monto} / {$ref}" : $monto;

            return ['label' => $label, 'monto_ref' => $montoRef];
        })->values()->toArray();
    }

    /**
     * Devuelve [destino, método, referencia] resumidos para mostrar en una sola fila de detalle.
     * Si hay varios pagos, los concatena con " / ".
     */
    private function resumenPagos($payments): array
    {
        if ($payments->isEmpty()) {
            return ['', '', ''];
        }

        $destinos    = [];
        $metodos     = [];
        $referencias = [];

        foreach ($payments as $p) {
            $destinos[]    = $this->destinoLabel($p);
            $metodos[]     = $p->paymentMethod?->description ?? '';
            $referencias[] = $p->numero_operacion ?? $p->numero ?? '';
        }

        return [
            implode(' / ', array_unique(array_filter($destinos))),
            implode(' / ', array_unique(array_filter($metodos))),
            implode(' / ', array_unique(array_filter($referencias))),
        ];
    }

    private function destinoLabel($payment): string
    {
        if (!$payment->destination_type || !$payment->destination_id) {
            return '';
        }

        if ($payment->destination_type === Cash::class) {
            $ref = $payment->destination?->reference_number;
            return 'Caja' . ($ref ? ' N°' . $ref : ' General');
        }

        if ($payment->destination_type === BankAccount::class) {
            return $payment->destination?->description ?? 'Cuenta Bancaria';
        }

        return '';
    }

    private function getGroupLabel(Carbon $fecha): string
    {
        if ($this->agrupacion === 'semanal') {
            $ini = $fecha->copy()->startOfWeek()->format('d-m-Y');
            $end = $fecha->copy()->endOfWeek()->format('d-m-Y');
            return "Sem {$ini} {$end}";
        }

        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        return $meses[$fecha->month] . ' ' . $fecha->year;
    }
}
