<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

use App\Helpers\PaymentDestinationHelper;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;
use App\Http\Requests\VentasRequest;
use App\Models\Clientes;
use App\Models\CodigosDetracciones;
use App\Models\NotificacionCobro;
use App\Models\PaymentMethodType;
use App\Models\Payments;
use App\Models\plantilla;
use App\Models\Series;
use App\Models\TipoComprobantes;
use App\Models\Ventas;
use App\Models\Productos;
use App\Models\Dispositivos;
use App\Services\FactilizaService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;


class Emitir extends Component
{
    //PROPIEDADES DE VENTA
    public $tipo_comprobante_id, $serie, $correlativo, $serie_correlativo, $cliente_id,
        $direccion, $fecha_emision, $fecha_hora_emision, $fecha_vencimiento,
        $divisa = "PEN", $tipo_cambio, $metodo_pago_id = "009", $comentario,
        $igv_op = 0.00, $tipo_descuento = "cantidad", $descuento_factor,
        $adelanto = 0.00,  $numero_cuotas = 0,
        $vence_cuotas = 30, $forma_pago = "CONTADO";

    public $sub_total = 0.00, $op_gravadas = 0.00, $op_exoneradas = 0.00, $op_inafectas = 0.00,
        $op_gratuitas = 0.00, $descuento = 0.00, $igv = 0.00, $icbper = 0.00,  $total;


    public Collection $detalle_cuotas;
    public Collection $pagos_detalle;

    //PROPIEDADES UTILES
    public $comprobante_slug;
    public $showCredit = false;
    public $product_selected_id;
    public $descuento_monto = 0.00;
    public $total_cuotas = 0.00;

    public Collection $items;
    public $cliente;
    public plantilla $plantilla;


    public $simbolo = "S/. ";

    public $metodo_type = "02";

    //PROPIEDAD PARA ASIGNAR EL MINIMO DEL CORRELATIVO
    public $min_correlativo;

    //DISMINUIR STOCK
    public $decrease_stock = true;


    public $tipo_operacion = '0101';
    public $detraccion = false;
    public $openModalDt = false;
    public Collection $datosDetraccion;


    //pago anticipado
    public $pago_anticipado = false;
    public $deduce_anticipos = false;
    public Collection $prepayments;
    public $total_anticipos = 0.00;
    public $igv_anticipos = 0.00;


    //PROPIEDAD PARA VERIFICAR EMPRESA
    public $empresa_id;

    // Contexto de Cobros (para auto-update y redirect)
    public $cobro_id = null;
    public $notificacion_ids_array = [];
    public $cobro_redirect_back = null;

    // Modal selección de IMEI para equipos GPS
    public bool $showImeiModal = false;
    public array $pendingGpsItem = [];
    public array $selectedImeis = [];  // [{id, imei}] acumulando selecciones durante el modal
    public ?int $editingImeiIndex = null;  // índice del item editado, null = modo añadir
    public string $imeiSearch = '';


    /**
     * Computed property para destinos de pago (Caja + Cuentas Bancarias)
     */
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    /**
     * Computed property para métodos de pago desde catálogo SUNAT
     */
    #[Computed]
    public function paymentMethods()
    {
        return PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($method) => [
                'id' => $method->id,
                'name' => $method->description,
            ]);
    }

    public function render()
    {
        return view('livewire.admin.facturacion.ventas.emitir');
    }

    public function openModalDetraccion()
    {
        $this->openModalDt = true;
    }

    public function updatedDatosDetraccionCodigoDetraccion($value)
    {
        if ($value) {
            $dt = CodigosDetracciones::where('codigo', $value)->first();
            $this->datosDetraccion['porcentaje'] = $dt->porcentaje;
            $this->calcularMontoDetraccion($this->total);
            $this->calcularCuotas($this->numero_cuotas);
        } else {
            $this->datosDetraccion['porcentaje'] = 0.00;
            $this->datosDetraccion['monto'] = 0.00;
        }
    }

    public function calcularMontoDetraccion($total)
    {
        $monto = $total * ($this->datosDetraccion['porcentaje'] / 100);

        if ($this->divisa == 'USD') {

            $this->datosDetraccion['monto'] = round($monto * $this->tipo_cambio);
        } else {

            $this->datosDetraccion['monto'] = round($monto);
        }
    }

    public function mount($notificacion_ids = null)
    {
        //DEFINIR EL TIPO DE COMPROBANTE
        $this->tipo_comprobante_id = TipoComprobantes::where('slug', $this->comprobante_slug)->first()->codigo;
        $this->setSerieMount();

        //ESTABLACER FECHAS DEFAULT
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        //$this->fecha_hora_emision = Carbon::now();
        //$this->fecha_hora_emision = "2023-07-20 11:44:00";
        $this->fecha_vencimiento = Carbon::now()->format('Y-m-d');
        // $this->fecha_vencimiento = "2023-07-20 11:44:00";

        $this->items = collect();
        $this->detalle_cuotas = collect();

        // Inicializar con un pago vacío
        $this->pagos_detalle = collect([
            [
                'metodo_pago_id' => '009',
                'payment_destination_id' => '',
                'referencia' => '',
                'monto' => 0.00,
            ]
        ]);

        //  CONSULTAR TIPO CAMBIO
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarTipoCambio();
        $this->tipo_cambio = $resultado['venta'] ?? 0;

        //$comprobante;

        if ($this->tipo_comprobante_id == "03") {
            $this->cliente_id = 1;
            $this->cliente = Clientes::find(1);
        }

        if ($this->tipo_comprobante_id == '02') {

            $this->metodo_type = '03';
        }
        $this->plantilla = plantilla::first();


        //DETRACCION INICIALIZAR DATOS
        $this->datosDetraccion = collect([
            'codigo_detraccion' => '',
            'porcentaje' => 0.00,
            'monto' => 0.00,
            'metodo_pago_id' => '001',
            'cuenta_bancaria' => $this->plantilla->cuenta_detraccion,
        ]);

        $this->prepayments = collect();

        $this->empresa_id = plantilla::first()->empresa->id;

        // Asignar cliente y contexto desde NotificacionCobro
        if ($notificacion_ids) {
            $ids = is_array($notificacion_ids) ? $notificacion_ids : $notificacion_ids;
            $firstNotif = NotificacionCobro::with(['cobro.clientes', 'cliente'])->find(
                is_array($ids) ? $ids[0] : $ids
            );

            if ($firstNotif) {
                $cobro = $firstNotif->cobro;
                $this->cliente    = $firstNotif->cliente;
                $this->direccion  = $this->cliente->direccion ?? '';
                $this->cliente_id = $firstNotif->cliente_id;
                $this->divisa     = $firstNotif->moneda ?? $cobro->divisa ?? 'PEN';
                $this->simbolo    = $this->divisa === 'USD' ? '$' : 'S/. ';
                $this->cobro_id   = $firstNotif->cobro_id;
                $this->cobro_redirect_back = session('cobro_redirect_back');

                $sessionFormaPago = session('cobro_forma_pago');
                if ($sessionFormaPago) {
                    $this->forma_pago = $sessionFormaPago;
                    $this->showCredit = $sessionFormaPago === 'CREDITO';
                    session()->forget('cobro_forma_pago');
                }
            }

            $this->notificacion_ids_array = is_array($ids) ? $ids : [$ids];

            $this->procesarItemsDesdeNotificaciones($this->notificacion_ids_array);
        }
    }

    /**
     * Procesa items desde NotificacionCobro (nuevo flujo preferido).
     * El monto ya incluye totales por periodo, divisa y ajuste IGV/RECIBO.
     */
    public function procesarItemsDesdeNotificaciones(array $notificacionIds): void
    {
        $notificaciones = NotificacionCobro::with([
            'detalleCobro.planModel',
            'cobro.producto.unit',
            'vehiculo',
        ])->whereIn('id', $notificacionIds)->get();

        $servicioCobro = Productos::getServicioCobro();
        $servicioDescripcion = $servicioCobro?->descripcion ?? '';

        foreach ($notificaciones as $notificacion) {
            $detalle  = $notificacion->detalleCobro;
            $cobro    = $notificacion->cobro;
            $vehiculo = $notificacion->vehiculo;
            $producto = $cobro->producto;

            $montoTotal = (float) $notificacion->monto;
            $esFactura  = ($cobro->tipo_pago ?? 'FACTURA') !== 'RECIBO';

            // Extraer valor_unitario del total (cantidad = 1 siempre)
            if ($esFactura) {
                $tasaIgv         = (float) $this->plantilla->igv; // 0.18
                $valorUnitario   = round($montoTotal / (1 + $tasaIgv), 4);
                $igvProducto     = round($montoTotal - $valorUnitario, 4);
                $codigoAfectacion = '10';
                $porcentajeIgv   = 18;
            } else {
                $valorUnitario   = $montoTotal;
                $igvProducto     = 0.00;
                $codigoAfectacion = '20';
                $porcentajeIgv   = 0;
            }

            // Construir descripción con periodo
            $periodo = $detalle?->periodo ?? $cobro->periodo ?? 'MENSUAL';
            $periodoTexto = match (strtoupper((string) $periodo)) {
                'BIMENSUAL'  => '2 meses',
                'TRIMESTRAL' => '3 meses',
                'SEMESTRAL'  => '6 meses',
                'ANUAL'      => '12 meses',
                default      => '1 mes',
            };

            $planNombre  = $detalle?->planModel?->name ?? $producto?->descripcion ?? 'Servicio GPS';
            $placa       = $vehiculo?->placa ?? 'S/P';
            $fechaInicio = $detalle?->fecha_inicio?->format('d/m/Y') ?? '';
            $fechaVence  = $notificacion->fecha_vencimiento?->format('d/m/Y') ?? '';
            $descripcion = trim("{$servicioDescripcion} {$planNombre} - periodo {$periodoTexto} placa {$placa} inicio {$fechaInicio} - fin {$fechaVence}");

            $this->addProducto([
                'producto_id'       => $cobro->producto_id,
                'codigo'            => $producto->codigo,
                'cantidad'          => 1,
                'unit'              => $producto->unit_code,
                'unit_name'         => $producto->unit->descripcion,
                'descripcion'       => $descripcion,
                'valor_unitario'    => $valorUnitario,
                'precio_unitario'   => round($valorUnitario * (1 + (float) $this->plantilla->igv), 4),
                'igv'               => $igvProducto,
                'porcentaje_igv'    => $porcentajeIgv,
                'icbper'            => 0.00,
                'total_icbper'      => 0.00,
                'sub_total'         => $valorUnitario,
                'total'             => $montoTotal,
                'codigo_afectacion' => $codigoAfectacion,
                'afecto_icbper'     => false,
                'tipo'              => $producto->tipo,
            ]);
        }
    }

    public function updatedClienteId($value)
    {

        if ($value) {
            //dd(Clientes::findOrFail($value)->direccion);
            $this->direccion = Clientes::findOrFail($value)->direccion;
            $this->cliente = Clientes::findOrFail($value);
        }
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', $this->tipo_comprobante_id)->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
        $this->min_correlativo = $serie->correlativo + 1;
        $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
    }

    public function updatedSerie($value)
    {
        $this->changeSerieUpdate($value);
    }

    public function changeSerieUpdate($serie)
    {

        if ($serie) {

            $serie = Series::where('serie', $serie)->first();
            $this->serie = $serie->serie;
            $this->correlativo = $serie->correlativo + 1;
            $this->min_correlativo = $serie->correlativo + 1;
            $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
        } else {

            $this->reset('correlativo');
        }
    }

    public function updatedDivisa($value)
    {
        if ($value == "USD") {
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }

        $this->calcularMontoDetraccion($this->total);
    }

    public function updatedFormaPago()
    {
        $this->toggleShowCredit();
    }


    public function toggleShowCredit()
    {

        if ($this->forma_pago == "CREDITO") {

            $this->showCredit = true;
            $this->resetCrediFields();
        } else {
            $this->showCredit = false;
        }
    }

    public function resetCrediFields()
    {
        $this->numero_cuotas = 0;
        $this->adelanto = 0.00;
        $this->detalle_cuotas = collect();
    }

    public function updatedNumeroCuotas($value)
    {

        $this->calcularCuotas($value);
    }

    public function updatedVenceCuotas($value)
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function calcularCuotas($nCuotas)
    {
        $this->detalle_cuotas = collect();
        $fecha = Carbon::now();
        //$this->total_cuotas = 0.00;
        for ($i = 0; $i < (int)$nCuotas; $i++) {

            $importe = 0.00;

            if ($this->divisa == 'USD') {
                $importe = round(floatval(($this->detraccion ? ($this->total - ($this->datosDetraccion['monto'] / $this->tipo_cambio)) : $this->total) / $nCuotas), 2);
            } else {
                $importe = round(floatval(($this->detraccion ? ($this->total - $this->datosDetraccion['monto']) : $this->total) / $nCuotas), 2);
            }

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays((int)$this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => ucfirst($fecha->dayName),
                'importe' => $this->total > 0 ? $importe : 0.00,
            ]);
        }
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }



    public function updatedDetalleCuotas($attr, $valor)
    {

        $this->detalle_cuotas = $this->detalle_cuotas->map(function ($item, $key) use ($attr, $valor) {

            // $item['fecha'] = $valor['fecha'];
            $item['dia_semana'] = ucfirst(Carbon::parse($item['fecha'])->dayName);
            $item['dias'] = Carbon::parse($item['fecha'])->diffInDays(Carbon::now());
            return $item;
        });

        $this->validate(['detalle_cuotas.*.fecha' => 'required|date|after_or_equal:fecha_emision'], [
            'detalle_cuotas.*.fecha.after_or_equal' => 'La fecha de vencimiento de la cuota debe ser mayor o igual a la fecha de emisión',
        ]);
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    public function openModalCreateProduct()
    {
        $this->dispatch('openModalCreate');
    }

    //AÑADIR ITEM SELECCIONADO A LA LISTA DE ITEMS
    #[On('add-producto-selected')]
    function addProducto($selected)
    {
        try {
            // Si el producto es equipo GPS (es_dispositivo + categoria gps), solicitar IMEI primero
            if (!empty($selected['es_dispositivo']) && !empty($selected['categoria_es_gps']) && !empty($selected['modelo_id'])) {
                $this->pendingGpsItem = $selected;
                $this->imeiSearch = '';
                $this->showImeiModal = true;
                return;
            }

            $this->items->push([
                'producto_id' => $selected["producto_id"],
                'codigo' => $selected["codigo"],
                'cantidad' => $selected["cantidad"],
                'unit' => $selected["unit"],
                'unit_name' => $selected["unit_name"],
                'descripcion' => $this->pago_anticipado ? $selected["descripcion"] . "***Pago Anticipado***" : $selected["descripcion"],
                'valor_unitario' => $selected["valor_unitario"],
                'precio_unitario' => $selected["precio_unitario"],
                'igv' => $selected["igv"],
                'porcentaje_igv' => $selected["porcentaje_igv"],
                'icbper' => $selected["icbper"],
                'total_icbper' => $selected["total_icbper"],
                'sub_total' => round($selected["valor_unitario"] * $selected["cantidad"], 4),
                'total' => $selected["total"],
                'codigo_afectacion' => $selected["codigo_afectacion"],
                'afecto_icbper' => $selected["afecto_icbper"],
                'tipo' => $selected["tipo"],
            ]);

            //ENVIAR EVENTO PARA REINICIAR PRODUCTO SELECCIONADO EN MODAL
            $this->dispatch('reset-selected');

            //  CALCULAR TOTALES AL AÑADIR PRODUCTO
            $this->reCalTotal();


            // $this->calcularCuotas($this->numero_cuotas);
            // }
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR PRODUCTO',
                mensaje: $e->getMessage(),
            );
        }
    }

    /** Dispositivos en STOCK del modelo pendiente, filtrados por búsqueda de IMEI */
    #[Computed]
    public function dispositivosImei()
    {
        if (empty($this->pendingGpsItem['modelo_id'])) {
            return collect();
        }
        $excludeIds = collect($this->selectedImeis)->pluck('id')->toArray();
        return Dispositivos::where('modelo_id', $this->pendingGpsItem['modelo_id'])
            ->where('estado', Dispositivos::STOCK)
            ->whereNotIn('id', $excludeIds)
            ->when($this->imeiSearch, fn($q) => $q->where('imei', 'like', '%' . $this->imeiSearch . '%'))
            ->limit(50)
            ->get();
    }

    /** Cada clic agrega un IMEI; cuando count == cantidad, cierra el modal */
    public function confirmarImei(int $dispositivoId): void
    {
        $dispositivo = Dispositivos::findOrFail($dispositivoId);
        $this->selectedImeis[] = ['id' => $dispositivo->id, 'imei' => $dispositivo->imei];
        $this->imeiSearch = '';

        $needed = (int) ($this->pendingGpsItem['cantidad'] ?? 1);
        if (count($this->selectedImeis) < $needed) {
            // Mantener modal abierto hasta completar la selección
            return;
        }

        // Todos los IMEIs seleccionados — construir el item
        $item        = $this->pendingGpsItem;
        $imeiList    = collect($this->selectedImeis)->pluck('imei')->join(', ');
        $imeiIds     = collect($this->selectedImeis)->pluck('id')->toArray();
        $wasEditing  = $this->editingImeiIndex !== null;

        $newItemData = [
            'producto_id'       => $item['producto_id'],
            'codigo'            => $item['codigo'],
            'cantidad'          => $item['cantidad'],
            'unit'              => $item['unit'],
            'unit_name'         => $item['unit_name'],
            'descripcion'       => $this->pago_anticipado ? $item['descripcion'] . '***Pago Anticipado***' : $item['descripcion'],
            'descripcion_pdf'   => $item['descripcion'] . ' IMEI: ' . $imeiList,
            'imeis'             => $imeiIds,
            'modelo_id'         => $item['modelo_id'] ?? null,
            'valor_unitario'    => $item['valor_unitario'],
            'precio_unitario'   => $item['precio_unitario'],
            'igv'               => $item['igv'] ?? 0,
            'porcentaje_igv'    => $item['porcentaje_igv'] ?? 0,
            'icbper'            => $item['icbper'],
            'total_icbper'      => $item['total_icbper'],
            'sub_total'         => round($item['valor_unitario'] * $item['cantidad'], 4),
            'total'             => $item['total'],
            'codigo_afectacion' => $item['codigo_afectacion'],
            'afecto_icbper'     => $item['afecto_icbper'],
            'tipo'              => $item['tipo'],
        ];

        if ($wasEditing) {
            $itemsArr = $this->items->toArray();
            $itemsArr[$this->editingImeiIndex] = $newItemData;
            $this->items = collect($itemsArr);
        } else {
            $this->items->push($newItemData);
        }

        $this->showImeiModal = false;
        $this->pendingGpsItem = [];
        $this->selectedImeis = [];
        $this->editingImeiIndex = null;
        $this->imeiSearch = '';
        if (!$wasEditing) {
            $this->dispatch('reset-selected');
        }
        $this->reCalTotal();
    }

    /** Eliminar un IMEI de la selección actual (dentro del modal) */
    public function quitarImeiSeleccionado(int $index): void
    {
        unset($this->selectedImeis[$index]);
        $this->selectedImeis = array_values($this->selectedImeis);
    }

    /** Abrir modal para editar los IMEIs de un item ya añadido */
    public function editarImeis(int $index): void
    {
        $item = $this->items[$index];
        $this->editingImeiIndex = $index;

        $this->pendingGpsItem = [
            'producto_id'       => $item['producto_id'],
            'codigo'            => $item['codigo'],
            'cantidad'          => $item['cantidad'],
            'unit'              => $item['unit'],
            'unit_name'         => $item['unit_name'],
            'descripcion'       => $item['descripcion'],  // campo SUNAT limpio, nunca se toca
            'valor_unitario'    => $item['valor_unitario'],
            'precio_unitario'   => $item['precio_unitario'],
            'igv'               => $item['igv'] ?? 0,
            'porcentaje_igv'    => $item['porcentaje_igv'] ?? 0,
            'icbper'            => $item['icbper'],
            'total_icbper'      => $item['total_icbper'],
            'sub_total'         => $item['sub_total'] ?? 0,
            'total'             => $item['total'],
            'codigo_afectacion' => $item['codigo_afectacion'],
            'afecto_icbper'     => $item['afecto_icbper'],
            'tipo'              => $item['tipo'],
            'modelo_id'         => $item['modelo_id'] ?? null,
        ];

        // Reconstruir selectedImeis desde los IDs guardados
        if (!empty($item['imeis']) && is_array($item['imeis'])) {
            $dispositivos = Dispositivos::whereIn('id', $item['imeis'])->get(['id', 'imei'])->keyBy('id');
            $this->selectedImeis = collect($item['imeis'])->map(function ($id) use ($dispositivos) {
                return ['id' => $id, 'imei' => $dispositivos->get($id)?->imei ?? "ID:{$id}"];
            })->toArray();
        } else {
            $this->selectedImeis = [];
        }

        $this->imeiSearch = '';
        $this->showImeiModal = true;
    }

    /** Cancelar selección de IMEI */
    public function cancelarImei(): void
    {
        $this->showImeiModal = false;
        $this->pendingGpsItem = [];
        $this->selectedImeis = [];
        $this->editingImeiIndex = null;
        $this->imeiSearch = '';
        $this->dispatch('reset-selected');
    }

    #[On('add-prepayment')]
    public function addPrepayment($prepayments)
    {

        $this->prepayments->push($prepayments);
        $this->dispatch('reset-prepayments');
        $this->calcularAnticipos();
    }

    public function save()
    {


        if ($this->empresa_id != session('empresa')) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: 'No puedes registrar una venta de otra empresa',
            );
            return;
        }

        $request = new VentasRequest();
        $datos = $this->validate($request->rules($this->detraccion), $request->messages());
        try {
            DB::beginTransaction();
            $venta = Ventas::create($datos);

            //ACTUALIZAR DIRECCION
            if (is_null($this->cliente->direccion)) {

                $this->cliente->direccion = $datos["direccion"];
                $this->cliente->save();
            }

            //CREAR ITEMS DE LA VENTA
            Ventas::createItems($venta, $datos["items"], $this->decrease_stock);

            // Marcar dispositivos GPS como VENDIDO
            $dispositivosIds = collect($this->items)
                ->flatMap(function ($item) {
                    if (!empty($item['imeis']) && is_array($item['imeis'])) {
                        return $item['imeis'];
                    }
                    return [];
                })
                ->filter()
                ->unique()
                ->values();
            if ($dispositivosIds->isNotEmpty()) {
                Dispositivos::whereIn('id', $dispositivosIds)
                    ->update(['estado' => Dispositivos::VENDIDO]);
            }

            //SI DETRACCION ES TRUE CREAR DETRACCION
            if ($this->detraccion) {
                $venta->detraccion()->create([
                    'codigo_detraccion' => $this->datosDetraccion['codigo_detraccion'],
                    'porcentaje' => $this->datosDetraccion['porcentaje'],
                    'monto' => $this->datosDetraccion['monto'],
                    'metodo_pago_id' => $this->datosDetraccion['metodo_pago_id'],
                    'cuenta_bancaria' => $this->datosDetraccion['cuenta_bancaria'],
                    'tipo_cambio' => $this->tipo_cambio,
                ]);
            }

            //SI ES ANTICIPO REGISTRAR ANTICIPO
            if ($this->deduce_anticipos) {

                Ventas::createPrepayments($venta, $this->prepayments);
            }

            //CREAR REGISTROS DE PAYMENT DESDE PAGOS_DETALLE
            if ($this->forma_pago === 'CONTADO') {
                // Validar que cada pago con monto tenga destino seleccionado
                foreach ($this->pagos_detalle as $i => $pago) {
                    if (!empty($pago['monto']) && floatval($pago['monto']) > 0) {
                        $destino = PaymentDestinationHelper::parseDestination($pago['payment_destination_id'] ?? null);
                        if (!$destino || !$destino['destination_id']) {
                            throw new \Exception('El pago #' . ($i + 1) . ' no tiene un destino de pago seleccionado.');
                        }
                    }
                }

                $total_pagos = 0;

                foreach ($this->pagos_detalle as $pago) {
                    // Omitir pagos sin monto
                    if (empty($pago['monto']) || floatval($pago['monto']) <= 0) {
                        continue;
                    }

                    $destinationRecord = PaymentDestinationHelper::parseDestination($pago['payment_destination_id'] ?? null);

                    Payments::create([
                        'paymentable_type' => Ventas::class,
                        'paymentable_id' => $venta->id,
                        'payment_method_id' => $pago['metodo_pago_id'],
                        'destination_type' => $destinationRecord['destination_type'],
                        'destination_id' => $destinationRecord['destination_id'],
                        'numero_operacion' => $pago['referencia'] ?? null,
                        'monto' => $pago['monto'],
                        'fecha' => $this->fecha_emision,
                        'divisa' => $this->divisa,
                        'cobros_id' => $this->cobro_id,
                        'user_id' => Auth::user()->id,
                        'empresa_id' => $this->empresa_id,
                    ]);

                    $total_pagos += floatval($pago['monto']);
                }

                // Solo marcar PAID si los pagos cubren el total completo
                if (round($total_pagos, 2) >= round($this->total, 2)) {
                    $venta->pago_estado = 'PAID';
                    $venta->save();
                }
            }

            //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
            $venta->getSerie->increment('correlativo');

            // AUTO-UPDATE desde flujo de notificaciones
            if (!empty($this->notificacion_ids_array)) {
                $notificaciones = NotificacionCobro::with(['detalleCobro', 'cobro'])
                    ->whereIn('id', $this->notificacion_ids_array)->get();

                // Renovar período de cada detalle individualmente (si auto_renovar)
                // El DetalleCobroObserver sincronizará la suscripción automáticamente
                foreach ($notificaciones as $notif) {
                    $det   = $notif->detalleCobro;
                    $cobro = $notif->cobro;

                    if ($det && $cobro) {
                        $nuevoInicio = $notif->fecha_vencimiento->copy();
                        // Usar periodo del DetalleCobro (fuente correcta) con NoOverflow
                        // para que 30-ene + 1 mes = 28-feb (no 02-mar)
                        $periodoDetalle = strtoupper($det->periodo ?? 'MENSUAL');
                        $nuevoFin = match ($periodoDetalle) {
                            'BIMENSUAL'  => $nuevoInicio->copy()->addMonthsNoOverflow(2),
                            'TRIMESTRAL' => $nuevoInicio->copy()->addMonthsNoOverflow(3),
                            'SEMESTRAL'  => $nuevoInicio->copy()->addMonthsNoOverflow(6),
                            'ANUAL'      => $nuevoInicio->copy()->addYearNoOverflow(),
                            default      => $nuevoInicio->copy()->addMonthNoOverflow(),
                        };
                        // Actualiza fecha_inicio y fecha_vencimiento;
                        // el observer sincroniza la suscripción del vehículo
                        $det->update([
                            'fecha_inicio'      => $nuevoInicio,
                            'fecha_vencimiento' => $nuevoFin,
                        ]);
                    }
                }

                // Actualizar estado de NotificacionCobro
                $estadoNotif = $this->forma_pago === 'CONTADO' ? 'PAGADO' : 'FACTURADO';
                $notifData = [
                    'estado'            => $estadoNotif,
                    'venta_id'          => $venta->id,
                    'fecha_facturacion' => now(),
                ];
                if ($this->forma_pago === 'CONTADO') {
                    $notifData['fecha_pago'] = now();
                }
                NotificacionCobro::whereIn('id', $this->notificacion_ids_array)->update($notifData);
            }

            DB::commit();

            // Determinar redirect destino
            $redirectBack = $this->cobro_redirect_back ?: null;
            session()->forget('cobro_redirect_back');

            if ($this->metodo_type != '03') {
                $api = new ApiFacturacion();

                $mensaje = $api->emitirInvoice($venta, $this->metodo_type, $this->tipo_operacion);

                if ($mensaje['fe_codigo_error']) {
                    session()->flash('venta-registrada', $mensaje["fe_mensaje_error"] . ': Intenta enviar en un rato');
                } else {
                    session()->flash('venta-registrada', $mensaje['fe_mensaje_sunat']);
                }

                if ($redirectBack) {
                    return redirect($redirectBack);
                }
                $this->redirectRoute('admin.ventas.index');
            } else {
                session()->flash('venta-registrada', 'Nota de venta registrada');

                if ($redirectBack) {
                    return redirect($redirectBack);
                }
                $this->redirectRoute('admin.ventas.index');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterSave($mensaje)
    {
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'VENTA REGISTRADA',
            mensaje: $mensaje,
        );
    }

    //CALCULAR IGV Y SUN TOTAL AL MODIFICAR CANTIDAD DEL ITEM #
    public function updatedItems($name, $value)
    {
        $this->items = $this->items->map(function ($item, $key) {

            $item["igv"] =  $item["codigo_afectacion"] == '10' ? round(floatval($item["valor_unitario"] * $item["cantidad"]) * $this->plantilla->igv, 4) : 0.00;
            $item["sub_total"] =  round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]), 4);
            $item["total"] =  $item["afecto_icbper"] ? round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]) + $item["igv"] + $item["total_icbper"], 4)  : round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]) + $item["igv"], 4);
            //   $item["afecto_icbper"] ? $item["icbper"] = 0.50 * round(floatval($item["cantidad"])) : 0;
            $item["precio_unitario"] = ($item["valor_unitario"] * $this->plantilla->igv) + $item["valor_unitario"];

            return $item;
        });

        $this->reCalTotal();
    }

    //METODO GLOBAL PARA HACER CALCULOS
    public function reCalTotal()
    {

        $this->sub_total =   $this->calcularSubTotal();
        $this->descuento =  $this->calcularDescuento();
        $this->op_gravadas = $this->calcularOperacionesGravadas($this->descuento);
        $this->op_exoneradas = $this->calcularOperacionesExoneradas();
        $this->op_inafectas = $this->calcularOperacionesInafectas();

        $this->icbper = $this->calcularIcbper();

        $this->igv =  $this->calcularIgv();
        $this->total =  $this->calcularTotal();
        $this->calcularCuotas($this->numero_cuotas);

        //CALCULAR DETRACCION SI ES TRUE
        if ($this->detraccion) {
            $this->calcularMontoDetraccion($this->total);
        }

        // Recalcular montos de pagos cuando cambia el total
        if ($this->forma_pago === 'CONTADO' && $this->pagos_detalle->count() > 0) {
            $this->recalcularMontosPagos();
        }

        //$this->op_gratuitas = $this->calcularOperacionesGratuitas();
    }

    public function calcularAnticipos()
    {
        //CALCULAR ANTICIPOS
        $this->total_anticipos = $this->calcularTotalAnticipos();
        $this->igv_anticipos = $this->calcularIvgAnticipos();

        $this->reCalTotal();
    }

    //CALCULAR EL SUB TOTAL DE LOS ITEMS
    public function calcularSubTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["sub_total"];
            return round($sub_total, 4);
        });

        return $this->total_anticipos > 0 ? $sub_total->sum() - $this->total_anticipos : $sub_total->sum();
    }

    //CALCULAR IGV DESDE EL SUB TOTAL - FALTA POR TRAER EL PROCENTAJE DEL IUMPUESTO DE LA DB
    public function calcularIgv()
    {
        // Sumar el IGV ya calculado por ítem para evitar diferencias de redondeo
        // cuando el monto viene pre-calculado (flujo NotificacionCobro)
        $igv = round(
            $this->items
                ->where('codigo_afectacion', '10')
                ->sum(fn($item) => floatval($item['igv'])),
            4
        );

        if ($this->igv_anticipos > 0) {
            return round($igv - $this->igv_anticipos, 4);
        }

        return $igv;
    }

    //CALCULAR TOTALES DE LOS TIPOS DE AFECTACIONES
    public function calcularOperacionesGravadas($descuento)
    {
        $op_gravadas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '10') {
                $op_gravadas = 0.00;
                $op_gravadas = $op_gravadas + $item['sub_total'];
                return round($op_gravadas, 4);
            }
        })->sum();

        if ($descuento > 0) {

            return $op_gravadas - $descuento;
        } else {

            return round($op_gravadas - $this->total_anticipos, 4);
        }
    }

    // public function calcularOperacionesGratuitas()
    // {

    //     $op_gratuitas = $this->items->map(function ($item, $key) {

    //         if ($item['codigo_afectacion'] == '20') {
    //             $op_gratuitas = 0.00;
    //             $op_gratuitas = $op_gratuitas + $item['sub_total'];
    //             return round($op_gratuitas, 2);
    //         }
    //     })->sum();

    //     return round($op_gratuitas, 2);
    // }

    public function calcularOperacionesExoneradas()
    {
        $op_exoneradas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '20') {
                $op_exoneradas = 0.00;
                $op_exoneradas = $op_exoneradas + $item['sub_total'];
                return round($op_exoneradas, 4);
            }
        })->sum();

        return round($op_exoneradas, 4);
    }

    public function calcularOperacionesInafectas()
    {

        $op_inafectas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '30') {
                $op_inafectas = 0.00;
                $op_inafectas = $op_inafectas + $item['sub_total'];
                return round($op_inafectas, 4);
            }
        })->sum();

        return round($op_inafectas, 4);
    }

    public function calcularIcbper()
    {
        $icbper = $this->items->map(function ($item, $key) {

            if ($item['afecto_icbper']) {
                $icbper = 0.00;
                $icbper = $item["icbper"];
                return round($icbper * $item["cantidad"], 4);
            }
        })->sum();

        return round($icbper, 4);
    }

    //CALCUJLAR TOTAL DE ACUERDO AL TIPO DE DESCUENTO Y SI HAY
    public function calcularTotal()
    {
        if ($this->igv_anticipos > 0) {

            $total = (($this->op_gravadas + $this->op_exoneradas + $this->op_inafectas + $this->icbper) + $this->igv);

            return round($total, 4);
        } else {
            $total = ($this->op_gravadas + $this->op_exoneradas + $this->op_inafectas + $this->icbper) + $this->igv;

            return round($total, 4);
        }
    }

    public function calcularTotalAnticipos()
    {
        $total_anticipos = $this->prepayments->map(function ($item, $key) {

            $total_anticipos = 0.00;
            $total_anticipos = $total_anticipos + $item['valor_venta_ref'];
            return round($total_anticipos, 4);
        });

        return $total_anticipos->sum();
    }

    public function calcularIvgAnticipos()
    {
        $igv_anticipos = $this->prepayments->map(function ($item, $key) {

            $igv_anticipos = 0.00;
            $igv_anticipos = $igv_anticipos + $item['igv'];
            return round($igv_anticipos, 4);
        });

        return $igv_anticipos->sum();
    }

    public function updatedDescuentoMonto()
    {
        $this->validate([
            'descuento_monto' => [
                'lt:op_gravadas',
                'exclude_if:op_gravadas,0'
            ],
        ]);
        $this->reCalTotal();
    }

    public function updatedTipoDescuento()
    {
        $this->reCalTotal();
    }

    public function calcularDescuento()
    {
        // cantidad - porcentaje
        $descuento = 0.00;

        if ($this->tipo_descuento == "cantidad") {

            if ($this->total) {
                $rules = $this->validate([
                    'descuento_monto' => [
                        'min:0',
                    ],
                ]);
            }

            if ($this->sub_total && $this->descuento_monto > 0) {
                $descuento = $this->descuento_monto;
                $this->descuento_factor = round($this->descuento_monto / $this->sub_total, 5);
            }
        }
        // else {
        //     if ($this->total) {
        //         $rules = $this->validate([
        //             'descuento_monto' => [
        //                 'min:0',

        //             ],
        //         ]);
        //     }
        //     //calculcart el porncetaje del descuento del subtotal
        //     $descuento = ($this->op_gravadas * $this->descuento_monto) / 100;
        // }

        return round($descuento, 4);
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        if ($this->items->count() == 0) {
            $this->descuento_monto = 0.00;
            $this->descuento = 0.00;
        }
        $this->reCalTotal();
    }

    public function eliminarPrepayment($key)
    {
        unset($this->prepayments[$key]);
        $this->prepayments;
        $this->calcularAnticipos();
    }

    public function updated($propertyName)
    {
        $request = new VentasRequest();
        $this->validateOnly($propertyName, $request->rules(), $request->messages());
    }
    // ABRIR MODAL PARA REGISTRAR PRODUCTO Y AÑADIR AL COMPROBANTE
    public function openModalAddProducto()
    {
        $this->dispatch('openModalAddProducto');
    }

    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }

    public function updatedDetraccion()
    {
        if ($this->detraccion) {
            $this->tipo_operacion = '1001';
            $this->calcularMontoDetraccion($this->total);
        } else {
            $this->tipo_operacion = '0101';
        }
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function updatedPagoAnticipado($value)
    {

        if ($value) {
            $this->items = $this->items->map(function ($item) {
                $item['descripcion'] .= '***Pago Anticipado***';
                return $item;
            });
        } else {
            $this->items = $this->items->map(function ($item) {
                $item['descripcion'] = str_replace('***Pago Anticipado***', '', $item['descripcion']);
                return $item;
            });
        }
    }

    public function agregarPago()
    {
        $this->pagos_detalle->push([
            'metodo_pago_id' => '009',
            'payment_destination_id' => '',
            'referencia' => '',
            'monto' => 0.00,
        ]);
        $this->recalcularMontosPagos();
    }

    public function eliminarPago($index)
    {
        if ($this->pagos_detalle->count() > 1) {
            $this->pagos_detalle->forget($index);
            $this->pagos_detalle = $this->pagos_detalle->values(); // Reindexar
            $this->recalcularMontosPagos();
        } else {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Aviso',
                mensaje: 'Debe haber al menos un pago'
            );
        }
    }

    public function recalcularMontosPagos()
    {
        $cantidad_pagos = $this->pagos_detalle->count();

        if ($cantidad_pagos === 0) {
            return;
        }

        if ($cantidad_pagos === 1) {
            // Si hay un solo pago, asignar el total completo
            $this->pagos_detalle = $this->pagos_detalle->map(function ($pago) {
                $pago['monto'] = $this->total;
                return $pago;
            });
        } else {
            // Si hay múltiples pagos, dividir el total entre la cantidad
            $monto_por_pago = round($this->total / $cantidad_pagos, 2);
            $diferencia = round($this->total - ($monto_por_pago * $cantidad_pagos), 2);

            $this->pagos_detalle = $this->pagos_detalle->map(function ($pago, $index) use ($monto_por_pago, $diferencia, $cantidad_pagos) {
                // Asignar el monto dividido
                $pago['monto'] = $monto_por_pago;

                // Agregar la diferencia al último pago para cuadrar exactamente
                if ($index === $cantidad_pagos - 1 && $diferencia != 0) {
                    $pago['monto'] = round($pago['monto'] + $diferencia, 2);
                }

                return $pago;
            });
        }
    }
}
