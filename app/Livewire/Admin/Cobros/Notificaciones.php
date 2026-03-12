<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Cobros;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Models\NotificacionCobro;
use App\Models\PaymentMethodType;
use App\Helpers\PaymentDestinationHelper;
use App\Http\Controllers\Admin\PaymentsController;
use App\Jobs\GenerarNotificacionesCobro;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

/**
 * Gestiona las Notificaciones de Cobro.
 *
 * El modal de pago sigue el mismo patron que Payment.php:
 *   - numero secuencial (PaymentsController::setNextSequenceNumber)
 *   - tipo pago (FACTURA / RECIBO)
 *   - selector de documento (factura/boleta o recibo UNPAID del cliente)
 *   - metodo de pago
 *   - destino (caja abierta o cuenta bancaria via PaymentDestinationHelper)
 *   - divisa, monto, n operacion, nota
 *   - modo "crear nuevo" o "asociar pago existente"
 * Al confirmar: crea el Payment + llama marcarComoPagado() en la notificacion.
 */
class Notificaciones extends Component
{
    use WithPagination, WireUiActions;

    // Filtros de tabla
    public string $search = '';
    public string $estado = '';
    public $filtroVencimiento = null;
    public $clienteId = null;
    public string $perPage = '10';

    // Estado del modal de pago
    public bool $modalPago = false;
    public ?int $pagoNotificacionId = null;

    // Campos del formulario de pago (misma nomenclatura que Payment.php)
    public $pago_numero             = null;
    public $pago_fecha              = null;
    public string $pago_tipo_pago   = 'FACTURA';
    public string $pago_titulo_doc  = 'Factura / Boleta';
    public $pago_paymentable_type   = null;
    public $pago_paymentable_id     = null;
    public array $pago_documentos   = [];
    public $pago_payment_method_id = 1;
    public $pago_payment_destination_id = null;
    public bool $pago_showBankAccountSelector = false;
    public $pago_bank_account_id    = null;
    public string $pago_divisa      = 'PEN';
    public $pago_monto              = null;
    public $pago_numero_operacion   = null;
    public string $pago_nota        = '';

    // Modo crear / asociar
    public string $pago_mode     = 'create';
    public $pago_existing_id      = null;
    public array $pago_existing_list = [];

    // Modal generar notificaciones
    public bool $modalGenerarNotif = false;
    public int $generarDias = 7;

    // Selección múltiple para facturación en lote
    public array $notificacionesSeleccionadas = [];

    // Catalogos cargados en mount()
    public array $paymentsMethods = [];
    public $bankAccounts = [];

    protected $listeners = ['render'];

    public function mount(): void
    {
        $this->paymentsMethods = PaymentMethodType::whereActive(true)->get()->toArray();
        $this->bankAccounts    = BankAccount::where('status', true)->get();
    }

    // Computed: clientes con notificaciones (para filtro)
    #[Computed]
    public function clientes()
    {
        return Clientes::whereIn('id', NotificacionCobro::distinct()->pluck('cliente_id')->filter())
            ->orderBy('razon_social')
            ->get(['id', 'razon_social', 'numero_documento']);
    }

    // Computed: destinos de pago
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    // Render
    public function render()
    {
        $notificaciones = NotificacionCobro::query()
            ->with(['detalleCobro.vehiculo', 'cobro.clientes', 'venta.payments.paymentMethod', 'recibo.payments.paymentMethod'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('cobro.clientes', fn($c) => $c->where('razon_social', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('detalleCobro.vehiculo', fn($v) => $v->where('placa', 'like', '%' . $this->search . '%'))
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->estado, fn($q) => $q->where('estado', $this->estado))
            ->when($this->clienteId, fn($q) => $q->where('cliente_id', $this->clienteId))
            ->when($this->filtroVencimiento === 'vencidos', fn($q) => $q->vencidos())
            ->when($this->filtroVencimiento === 'hoy',     fn($q) => $q->whereDate('fecha_vencimiento', now()))
            ->when($this->filtroVencimiento === '7dias',   fn($q) => $q->porVencer(7))
            ->when($this->filtroVencimiento === '15dias',  fn($q) => $q->porVencer(15))
            ->orderBy('fecha_vencimiento', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $stats = [
            'pendientes'      => NotificacionCobro::pendientes()->count(),
            'vencidos'        => NotificacionCobro::vencidos()->count(),
            'hoy'             => NotificacionCobro::pendientes()->whereDate('fecha_vencimiento', now())->count(),
            'monto_pendiente_pen' => NotificacionCobro::pendientes()->where('moneda', 'PEN')->sum('monto'),
            'monto_pendiente_usd' => NotificacionCobro::pendientes()->where('moneda', 'USD')->sum('monto'),
        ];
        $paymentMethods = PaymentMethodType::whereActive(true)->get();
        return view('livewire.admin.cobros.notificaciones', compact('notificaciones', 'stats', 'paymentMethods'));
    }

    // Modal de pago - apertura
    public function abrirModalPago(int $notificacionId): void
    {
        $this->resetPago();

        $notificacion = NotificacionCobro::with(['cobro.clientes', 'detalleCobro'])->findOrFail($notificacionId);
        $this->pagoNotificacionId = $notificacionId;

        $this->pago_numero = (new PaymentsController())->setNextSequenceNumber();
        $this->pago_fecha  = Carbon::now()->format('Y-m-d');

        $cobro = $notificacion->cobro;
        $this->pago_divisa = $cobro->divisa ?? 'PEN';
        $this->pago_monto  = $notificacion->monto;

        $this->pago_tipo_pago = $cobro->tipo_pago === 'RECIBO' ? 'RECIBO' : 'FACTURA';
        $this->cargarDocumentos($cobro);

        $this->checkAvailableDestinations();
        $this->loadExistingPayments($cobro->clientes);

        $this->modalPago = true;
    }

    public function cerrarModalPago(): void
    {
        $this->modalPago = false;
        $this->resetPago();
    }

    // Reactivos del formulario de pago
    public function updatedPagoPaymentMethodId(int $id): void
    {
        $method = PaymentMethodType::find($id);

        if ($method && $method->is_credit == 1) {
            $this->pago_showBankAccountSelector = true;
            $this->bankAccounts = BankAccount::active()->get();
        } else {
            $this->pago_showBankAccountSelector = false;
            $this->pago_bank_account_id          = null;
        }
    }

    public function updatedPagoMonto($value): void
    {
        $cleaned = str_replace(',', '', (string) $value);
        if ($value !== null && $value !== '' && !is_numeric($cleaned)) {
            $this->addError('pago_monto', 'El monto ingresado no es un valor numérico válido');
        } else {
            $this->resetErrorBag('pago_monto');
            if ($cleaned !== '') {
                $this->pago_monto = $cleaned;
            }
        }
    }

    public function updatedPagoTipoPago(string $tipo): void
    {
        $this->reset('pago_paymentable_id');
        $notificacion = NotificacionCobro::with('cobro.clientes')->find($this->pagoNotificacionId);
        if ($notificacion) {
            $this->cargarDocumentos($notificacion->cobro);
        }
    }

    public function updatedPagoPaymentableId($id): void
    {
        if (!$id) {
            return;
        }

        if ($this->pago_paymentable_type === Ventas::class) {
            $doc = Ventas::find($id);
            if (!$doc) {
                return;
            }
            $this->pago_divisa = $doc->divisa;

            if ($doc->pago_estado === Ventas::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'VENTA YA PAGADA',
                    mensaje: 'Esta venta ya fue pagada completamente.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
        }

        if ($this->pago_paymentable_type === Recibos::class) {
            $doc = Recibos::find($id);
            if (!$doc) {
                return;
            }
            $this->pago_divisa = $doc->divisa;

            if ($doc->pago_estado === Recibos::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'RECIBO YA PAGADO',
                    mensaje: 'Este recibo ya fue pagado completamente.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
        }
    }

    // Guardar pago
    public function confirmarPago(): void
    {
        try {
            $notificacion = NotificacionCobro::with(['cobro', 'detalleCobro'])->findOrFail($this->pagoNotificacionId);

            if ($notificacion->estado !== 'PENDIENTE') {
                $this->notification()->error('Esta notificacion ya no esta pendiente');
                return;
            }

            // Modo ASOCIAR
            if ($this->pago_mode === 'associate') {
                if (empty($this->pago_existing_id)) {
                    $this->dispatch(
                        'notify-toast',
                        icon: 'error',
                        title: 'PAGO REQUERIDO',
                        mensaje: 'Selecciona un pago existente para asociar'
                    );
                    return;
                }

                $payment = Payments::findOrFail($this->pago_existing_id);
                $payment->update(['cobros_id' => $notificacion->cobro_id]);

                // Vincular documento (venta/recibo) a la notificacion
                if ($payment->paymentable_type === Ventas::class) {
                    $notificacion->venta_id = $payment->paymentable_id;
                } elseif ($payment->paymentable_type === Recibos::class) {
                    $notificacion->recibo_id = $payment->paymentable_id;
                }

                $notificacion->marcarComoPagado();

                $this->notification()->success(
                    title: 'Pago Asociado',
                    description: "Pago #{$payment->numero} asociado y periodo avanzado"
                );
                $this->cerrarModalPago();
                $this->dispatch('render');
                return;
            }

            // Modo CREAR
            // Limpiar separadores de miles y validar formato antes de procesar
            if (is_string($this->pago_monto)) {
                $cleaned = str_replace(',', '', $this->pago_monto);
                if ($cleaned !== '' && !is_numeric($cleaned)) {
                    $this->addError('pago_monto', 'El monto ingresado no es un valor numérico válido');
                    return;
                }
                $this->pago_monto = $cleaned;
            }

            $this->validate([
                'pago_payment_method_id' => 'required',
                'pago_monto'             => 'required|numeric|min:0.01',
                'pago_fecha'             => 'required|date',
            ], [
                'pago_payment_method_id.required' => 'Selecciona un metodo de pago',
                'pago_monto.required'             => 'El monto es requerido',
                'pago_monto.min'                  => 'El monto debe ser mayor a cero',
                'pago_fecha.required'             => 'La fecha es requerida',
            ]);

            $this->pago_numero = (new PaymentsController())->setNextSequenceNumber();

            $destination = PaymentDestinationHelper::parseDestination($this->pago_payment_destination_id);

            $payment = Payments::create([
                'numero'            => $this->pago_numero,
                'fecha'             => $this->pago_fecha,
                'monto'             => $this->pago_monto,
                'divisa'            => $this->pago_divisa ?: 'PEN',
                'nota'              => $this->pago_nota ?: null,
                'numero_operacion'  => $this->pago_numero_operacion ?: null,
                'payment_method_id' => $this->pago_payment_method_id,
                'cobros_id'         => $notificacion->cobro_id,
                'paymentable_type'  => $this->pago_paymentable_id ? $this->pago_paymentable_type : null,
                'paymentable_id'    => $this->pago_paymentable_id ?: null,
                'documento'         => $this->pago_tipo_pago,
                'destination_type'  => $destination['destination_type'],
                'destination_id'    => $destination['destination_id'],
                'bank_account_id'   => $this->pago_bank_account_id ?: null,
            ]);

            // Marcar documento como PAID si corresponde
            if ($payment->paymentable) {
                $totalPagos = Payments::where('paymentable_type', $this->pago_paymentable_type)
                    ->where('paymentable_id', $this->pago_paymentable_id)
                    ->sum('monto');

                if ($totalPagos >= $payment->paymentable->total) {
                    $payment->paymentable->pago_estado = 'PAID';
                    $payment->paymentable->estado      = 'COMPLETADO';
                    $payment->paymentable->save();
                }
            }

            // Vincular documento (venta/recibo) a la notificacion
            if ($this->pago_paymentable_id) {
                if ($this->pago_paymentable_type === Ventas::class) {
                    $notificacion->venta_id = $this->pago_paymentable_id;
                } elseif ($this->pago_paymentable_type === Recibos::class) {
                    $notificacion->recibo_id = $this->pago_paymentable_id;
                }
            }

            $notificacion->marcarComoPagado();

            $this->notification()->success(
                title: 'Pago Registrado',
                description: "Pago {$payment->numero} guardado y periodo avanzado"
            );

            $this->cerrarModalPago();
            $this->dispatch('render');
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'Error al registrar el pago',
                description: $th->getMessage()
            );
        }
    }

    // Helpers privados del pago
    private function resetPago(): void
    {
        $this->reset([
            'pagoNotificacionId',
            'pago_numero',
            'pago_fecha',
            'pago_tipo_pago',
            'pago_titulo_doc',
            'pago_paymentable_type',
            'pago_paymentable_id',
            'pago_documentos',
            'pago_payment_method_id',
            'pago_payment_destination_id',
            'pago_showBankAccountSelector',
            'pago_bank_account_id',
            'pago_divisa',
            'pago_monto',
            'pago_numero_operacion',
            'pago_nota',
            'pago_mode',
            'pago_existing_id',
            'pago_existing_list',
        ]);
        $this->pago_payment_method_id = $this->paymentsMethods[0]['id'] ?? 1;
        $this->pago_divisa            = 'PEN';
        $this->pago_mode              = 'create';
    }

    private function cargarDocumentos(Cobros $cobro): void
    {
        $cliente = $cobro->clientes;

        if ($this->pago_tipo_pago === 'RECIBO' || $cobro->tipo_pago === 'RECIBO') {
            $this->pago_titulo_doc       = 'Numero de Recibo';
            $this->pago_paymentable_type = Recibos::class;
            $this->pago_documentos       = $this->loadRecibos($cliente);
        } else {
            $this->pago_titulo_doc       = 'Factura / Boleta';
            $this->pago_paymentable_type = Ventas::class;
            $this->pago_documentos       = $this->loadFacturas($cliente);
        }
    }

    private function loadFacturas($cliente): array
    {
        if (!$cliente) {
            return [];
        }

        return $cliente->ventas()
            ->where('pago_estado', 'UNPAID')
            ->get()
            ->map(fn($v) => [
                'id'    => $v->id,
                'text'  => $v->serie_correlativo,
                'monto' => $v->total,
                'divisa' => $v->divisa,
            ])
            ->toArray();
    }

    private function loadRecibos($cliente): array
    {
        if (!$cliente) {
            return [];
        }

        return $cliente->recibos()
            ->unpaid()
            ->get()
            ->map(fn($r) => [
                'id'    => $r->id,
                'text'  => $r->serie_numero,
                'monto' => $r->total,
                'divisa' => $r->divisa,
            ])
            ->toArray();
    }

    private function loadExistingPayments($cliente): void
    {
        if (!$cliente) {
            return;
        }

        $this->pago_existing_list = Payments::query()
            ->where(function ($q) use ($cliente) {
                $q->where(function ($inner) use ($cliente) {
                    $inner->where('paymentable_type', 'App\\Models\\Ventas')
                        ->whereIn('paymentable_id', Ventas::where('cliente_id', $cliente->id)->pluck('id'));
                })->orWhere(function ($inner) use ($cliente) {
                    $inner->where('paymentable_type', 'App\\Models\\Recibos')
                        ->whereIn('paymentable_id', Recibos::where('clientes_id', $cliente->id)->pluck('id'));
                });
            })
            ->whereNull('cobros_id')
            ->with('paymentable')
            ->latest()
            ->get()
            ->map(function ($p) {
                $doc = '';
                if ($p->paymentable_type === 'App\\Models\\Ventas') {
                    $doc = $p->paymentable?->serie_correlativo ?? 'FAC';
                } elseif ($p->paymentable_type === 'App\\Models\\Recibos') {
                    $doc = $p->paymentable?->serie_numero ?? 'REC';
                }
                return [
                    'id'    => $p->id,
                    'label' => "Pago #{$p->numero} - {$doc} - {$p->divisa} " . number_format($p->monto, 2) . " ({$p->fecha->format('d/m/Y')})",
                ];
            })
            ->toArray();
    }

    private function checkAvailableDestinations(): void
    {
        $hasCash        = Cash::where('estado', true)->exists();
        $hasBankAccount = BankAccount::where('status', true)->exists();

        if (!$hasCash && !$hasBankAccount) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin Destinos Disponibles',
                mensaje: 'No hay cajas abiertas ni cuentas bancarias activas.'
            );
        } elseif (!$hasCash) {
            $this->dispatch(
                'notify-toast',
                icon: 'info',
                title: 'Sin Caja Abierta',
                mensaje: 'No hay cajas abiertas. El pago en efectivo quedara sin destino.'
            );
        }
    }

    // Facturar (Emitir documento)
    public function redirectToFacturar(int $notificacionId): mixed
    {
        $notificacion = NotificacionCobro::with(['cobro.clientes'])->find($notificacionId);

        if (!$notificacion) {
            $this->notification()->error('Notificacion no encontrada');
            return null;
        }

        $cobro   = $notificacion->cobro;
        $cliente = $cobro->clientes;

        session([
            'cobro_forma_pago'      => 'CONTADO',
            'cobro_redirect_back'   => route('admin.cobros.notificaciones'),
            'notificacion_cobro_id' => $notificacionId,
        ]);

        $notificacionIds = json_encode([$notificacionId]);

        if ($cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'notificacion_ids' => $notificacionIds,
            ]);
        }

        if (($cliente->tipo_documento_id ?? null) == 6) {
            return redirect()->route('admin.factura.create', [
                'notificacion_ids' => $notificacionIds,
            ]);
        }

        return redirect()->route('admin.boleta.create', [
            'notificacion_ids' => $notificacionIds,
        ]);
    }

    // Selección individual con validación de cliente al momento de seleccionar
    public function toggleSeleccion(int $id, int $clienteId): void
    {
        // Si ya está seleccionado, deseleccionar
        if (in_array($id, $this->notificacionesSeleccionadas)) {
            $this->notificacionesSeleccionadas = array_values(
                array_filter($this->notificacionesSeleccionadas, fn($v) => (int) $v !== $id)
            );
            return;
        }

        // Verificar que no mezcle clientes distintos
        if (!empty($this->notificacionesSeleccionadas)) {
            $clienteExistente = NotificacionCobro::withoutGlobalScopes()
                ->whereIn('id', $this->notificacionesSeleccionadas)
                ->value('cliente_id');

            if ((int) $clienteExistente !== $clienteId) {
                $this->notification()->error(
                    title: 'Cliente diferente',
                    description: 'Solo puedes seleccionar notificaciones del mismo cliente.',
                );
                return;
            }
        }

        $this->notificacionesSeleccionadas[] = $id;
    }

    // Selección múltiple de página (select-all) con validación de cliente
    public function seleccionarIds(array $ids): void
    {
        $nuevas = NotificacionCobro::withoutGlobalScopes()
            ->whereIn('id', array_map('intval', $ids))
            ->where('estado', 'PENDIENTE')
            ->get(['id', 'cliente_id']);

        $clienteIdActual = null;
        if (!empty($this->notificacionesSeleccionadas)) {
            $clienteIdActual = NotificacionCobro::withoutGlobalScopes()
                ->whereIn('id', $this->notificacionesSeleccionadas)
                ->value('cliente_id');
        }

        $idsValidos = [];
        foreach ($nuevas as $notif) {
            if ($clienteIdActual === null) {
                $clienteIdActual = $notif->cliente_id;
            }
            if ((int) $notif->cliente_id !== (int) $clienteIdActual) {
                $this->notification()->error(
                    title: 'Clientes distintos en la página',
                    description: 'La selección múltiple solo funciona cuando todas las notificaciones PENDIENTE de la página son del mismo cliente.',
                );
                return;
            }
            $idsValidos[] = $notif->id;
        }

        $this->notificacionesSeleccionadas = array_values(array_unique(
            array_merge($this->notificacionesSeleccionadas, $idsValidos)
        ));
    }

    // Selección múltiple: quita IDs del array de seleccionadas
    public function deseleccionarIds(array $ids): void
    {
        $ids = array_map('intval', $ids);
        $this->notificacionesSeleccionadas = array_values(
            array_filter($this->notificacionesSeleccionadas, fn($v) => !in_array((int) $v, $ids))
        );
    }

    // Limpia toda la selección
    public function deseleccionarTodos(): void
    {
        $this->notificacionesSeleccionadas = [];
    }

    // Facturar las notificaciones seleccionadas (múltiple)
    public function redirectToFacturarSeleccionadas(): mixed
    {
        if (empty($this->notificacionesSeleccionadas)) {
            $this->notification()->error('Selecciona al menos una notificación.');
            return null;
        }

        $notificaciones = NotificacionCobro::with(['cobro.clientes'])
            ->whereIn('id', $this->notificacionesSeleccionadas)
            ->where('estado', 'PENDIENTE')
            ->get();

        if ($notificaciones->isEmpty()) {
            $this->notification()->error('No hay notificaciones PENDIENTE en la selección.');
            return null;
        }

        $firstNotif = $notificaciones->first();
        $cobro      = $firstNotif->cobro;
        $cliente    = $cobro->clientes;

        session([
            'cobro_forma_pago'    => 'CONTADO',
            'cobro_redirect_back' => route('admin.cobros.notificaciones'),
        ]);

        $notificacionIds = json_encode($notificaciones->pluck('id')->toArray());

        if ($cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'notificacion_ids' => $notificacionIds,
            ]);
        }

        if (($cliente->tipo_documento_id ?? null) == 6) {
            return redirect()->route('admin.factura.create', [
                'notificacion_ids' => $notificacionIds,
            ]);
        }

        return redirect()->route('admin.boleta.create', [
            'notificacion_ids' => $notificacionIds,
        ]);
    }

    // Cancelar
    public function cancelar(int $notificacionId): void
    {
        $this->dialog()->confirm([
            'title'       => 'Cancelar notificación de cobro',
            'description' => 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Sí, cancelar',
                'color'  => 'negative',
                'method' => 'confirmarCancelacion',
                'params' => $notificacionId,
            ],
            'reject' => ['label' => 'No, volver'],
        ]);
    }

    public function confirmarCancelacion(int $notificacionId): void
    {
        try {
            NotificacionCobro::findOrFail($notificacionId)
                ->cancelar('Cancelado desde el panel de notificaciones');

            $this->notification()->success('Notificacion cancelada correctamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error al cancelar: ' . $e->getMessage());
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'estado', 'filtroVencimiento', 'clienteId']);
        $this->resetPage();
    }

    public function abrirModalGenerarNotificaciones(): void
    {
        $this->generarDias = 7;
        $this->modalGenerarNotif = true;
    }

    public function ejecutarGenerarNotificaciones(): void
    {
        $this->validate(
            ['generarDias' => 'required|integer|min:1|max:15'],
            [
                'generarDias.required' => 'Ingrese los días de anticipación.',
                'generarDias.min'      => 'El mínimo es 1 día.',
                'generarDias.max'      => 'El máximo permitido es 15 días.',
            ]
        );

        try {
            GenerarNotificacionesCobro::dispatchSync($this->generarDias);
            $this->modalGenerarNotif = false;
            $this->notification()->success(
                title: 'Notificaciones generadas',
                description: "Se procesaron los cobros con {$this->generarDias} días de anticipación."
            );
            $this->dispatch('render');
        } catch (\Throwable $e) {
            $this->notification()->error(
                title: 'Error al generar',
                description: $e->getMessage()
            );
        }
    }
}
