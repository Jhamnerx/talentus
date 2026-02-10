<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Detalle de Cobranza ✨</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $cobro->clientes->razon_social }} -
            {{ $cobro->periodo }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4">

        @if ($detalleIds && count($detalleIds) > 0)
            <div class="col-span-full mb-6">
                <div
                    class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-xl shadow-xs p-6 border-2 border-indigo-200 dark:border-indigo-700/60">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-100">Acciones Masivas</h3>
                            <p class="text-sm text-indigo-600 dark:text-indigo-300 mt-1">
                                {{ count($detalleIds) }} vehículo(s) seleccionado(s)
                            </p>
                        </div>
                        <button wire:click="$set('detalleIds', [])"
                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 text-sm font-medium">
                            Limpiar selección
                        </button>
                    </div>

                    {{-- Alerta informativa --}}
                    <div
                        class="mb-4 p-4 bg-blue-50 dark:bg-blue-950/50 rounded-lg border-2 border-blue-300 dark:border-blue-600/50">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-blue-900 dark:text-blue-100">
                                <p class="font-bold mb-2 text-base">Emisión masiva:</p>
                                <p class="text-blue-800 dark:text-blue-200">
                                    Serás redirigido al módulo de emisión con los vehículos seleccionados. 
                                    Al guardar, el estado se actualizará automáticamente y regresarás aquí.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        {{-- Emitir Documento --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold">1</span>
                                Emitir Documento
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <x-form.button full="true" emerald wire:click="facturarMasivo('CONTADO')"
                                    right-icon="currency-dollar" label="Emitir CONTADO" />
                                <x-form.button full="true" amber wire:click="facturarMasivo('CRÉDITO')"
                                    right-icon="document-text" label="Emitir CRÉDITO" />
                            </div>
                        </div>

                        {{-- Opciones Avanzadas Masivas --}}
                        <details class="group">
                            <summary class="text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer hover:text-blue-600 flex items-center gap-2">
                                <span class="group-open:rotate-90 transition-transform">▶</span>
                                Opciones Avanzadas (elegir tipo de documento)
                            </summary>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mt-3">
                                @if ($cobro->clientes->tipo_documento_id == 6)
                                    <x-form.button full="true" sky wire:click.prevent="createFacturaGeneral()"
                                        right-icon="document-text" label="Crear Factura" />
                                @endif
                                @if ($cobro->clientes->tipo_documento_id == 1)
                                    <x-form.button full="true" cyan wire:click.prevent="createBoletaGeneral()"
                                        right-icon="document-text" label="Crear Boleta" />
                                @endif
                                <x-form.button full="true" slate wire:click.prevent="createReciboGeneral()"
                                    right-icon="document" label="Crear Recibo" />
                            </div>
                        </details>

                        {{-- Registrar Pago (para documentos ya emitidos) --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold">2</span>
                                Pago Pendiente (si ya fue facturado a crédito)
                            </h4>
                            <x-form.button full="true" primary wire:click="openModalPaymentBulk()"
                                right-icon="currency-dollar" label="Pagar Todo" />
                        </div>

                        {{-- Gestión de Estado --}}
                        <div>
                            <h4
                                class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Gestión de Estado
                            </h4>
                            <div class="grid grid-cols-2 gap-2">
                                <x-form.button full="true" warning wire:click="suspenderSeleccionados()"
                                    right-icon="pause" label="Suspender" />
                                <x-form.button full="true" positive wire:click="activarSeleccionados()"
                                    right-icon="check-circle" label="Activar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($cobro->detalle as $item)
            @php
                $diasRestantes = \Carbon\Carbon::now()->diffInDays($item->fecha, false);
                $colorClase = '';
                $colorBg = '';
                if ($diasRestantes > 30) {
                    $colorClase = 'text-emerald-600 dark:text-emerald-400';
                    $colorBorde = 'border-emerald-500 dark:border-emerald-600';
                    $colorBg = 'bg-emerald-50 dark:bg-emerald-900/20';
                } elseif ($diasRestantes <= 30 && $diasRestantes > 15) {
                    $colorClase = 'text-orange-500 dark:text-orange-400';
                    $colorBorde = 'border-orange-500 dark:border-orange-600';
                    $colorBg = 'bg-orange-50 dark:bg-orange-900/20';
                } elseif ($diasRestantes <= 15) {
                    $colorClase = 'text-red-500 dark:text-red-400';
                    $colorBorde = 'border-red-500 dark:border-red-600';
                    $colorBg = 'bg-red-50 dark:bg-red-900/20';
                }
            @endphp
            <div class="bg-white dark:bg-gray-800 p-6 shadow-xs rounded-xl border-l-4 {{ $colorBorde }}">

                <div
                    class="flex justify-between items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-700/60">
                    <x-form.checkbox id="size-sm" wire:model.live="detalleIds" value="{{ $item->id }}" md />
                    <div class="flex items-center gap-2 flex-1 mx-2">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $item->vehiculo ? $item->vehiculo->placa : 'Sin vehículo' }}
                        </h3>
                        @if ($item->estado == 0)
                            <span
                                class="px-2 py-1 text-xs font-semibold bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-400 rounded-full">Suspendido</span>
                        @else
                            <span
                                class="px-2 py-1 text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 rounded-full">Activo</span>
                        @endif
                    </div>
                </div>


                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Empresa</span>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $cobro->clientes->razon_social }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Placa</span>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $item->vehiculo ? $item->vehiculo->placa : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha Vencimiento</span>
                        <div class="flex items-center gap-2">
                            <span
                                class="text-sm font-semibold {{ $colorClase }}">{{ $item->fecha->format('d-m-Y') }}</span>
                            <x-form.button wire:click.prevent="refreshFecha({{ $item->id }})" icon="arrow-path" xs
                                primary />
                        </div>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Periodo</span>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $cobro->periodo }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Plan</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-100">S/.
                            {{ $item->plan }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Tipo Pago</span>
                        <span
                            class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $cobro->tipo_pago }}</span>
                    </div>
                </div>

                @livewire('admin.cobros.suspend', ['detalle' => $item], key('suspend' . $item->id))

                {{-- ESTADO DE FACTURACIÓN --}}
                <div class="border-t border-gray-200 dark:border-gray-700/60 pt-4 mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Estado de Facturación</h4>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $item->estado_facturacion?->color() ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $item->estado_facturacion?->icon() ?? '📋' }}
                            {{ $item->estado_facturacion?->label() ?? 'Sin Facturar' }}
                        </span>
                    </div>

                    {{-- MOSTRAR DOCUMENTO SI ESTÁ FACTURADO --}}
                    @if($item->estado_facturacion && 
                        ($item->estado_facturacion->value === 'FACTURADO' || $item->estado_facturacion->value === 'PAGADO'))
                        <div class="bg-gray-50 dark:bg-gray-900/20 rounded-lg p-3 mb-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Documento</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->numero_documento ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Fecha Facturación</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->fecha_facturacion?->format('d/m/Y') ?? '-' }}
                                    </p>
                                </div>
                            </div>
                            @if($item->estado_facturacion->value === 'PAGADO' && $item->fecha_pago)
                            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Fecha de Pago</p>
                                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                                    {{ $item->fecha_pago->format('d/m/Y') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    @endif

                    {{-- BOTONES INTELIGENTES SEGÚN ESTADO --}}
                    @if ($item->estado)
                        @php
                            $estadoFacturacion = $item->estado_facturacion?->value ?? 'SIN_FACTURAR';
                            $tipoDoc = $cobro->tipo_pago === 'RECIBO' ? 'Recibo' : ($cobro->clientes->tipo_documento_id == 6 ? 'Factura' : 'Boleta');
                        @endphp

                        @if($estadoFacturacion === 'SIN_FACTURAR')
                            {{-- SIN FACTURAR: Redirect inteligente al módulo Emitir/Create --}}
                            <div class="space-y-2">
                                @can('admin.ventas.create')
                                <button wire:click="facturarInteligente({{ $item->id }}, 'CONTADO')"
                                    class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                    <span>💰</span>
                                    <span>Emitir {{ $tipoDoc }} (CONTADO)</span>
                                </button>
                                @endcan
                                
                                @can('admin.ventas.create')
                                <button wire:click="facturarInteligente({{ $item->id }}, 'CRÉDITO')"
                                    class="w-full px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                    <span>📄</span>
                                    <span>Emitir {{ $tipoDoc }} (CRÉDITO)</span>
                                </button>
                                @endcan
                            </div>

                        @elseif($estadoFacturacion === 'FACTURADO')
                            {{-- FACTURADO PERO NO PAGADO: Mostrar doc + Botón para registrar pago --}}
                            @if($item->venta)
                                <div class="bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-700 rounded-lg p-3 mb-2 text-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Documento emitido</p>
                                    <p class="text-sm font-bold text-sky-700 dark:text-sky-300">{{ $item->venta->serie_numero }}</p>
                                </div>
                            @elseif($item->recibo)
                                <div class="bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-700 rounded-lg p-3 mb-2 text-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Recibo emitido</p>
                                    <p class="text-sm font-bold text-sky-700 dark:text-sky-300">{{ $item->recibo->serie_numero }}</p>
                                </div>
                            @endif
                            @can('admin.payments.create')
                            <div class="space-y-2">
                                <button wire:click="openModalPayment({{ $item->id }})"
                                    class="w-full px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                    <span>💳</span>
                                    <span>Registrar Pago</span>
                                </button>
                                
                                <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                    También puedes registrar el pago desde <br>
                                    <a href="{{ route('admin.finanzas.cuentas-cobrar.index') }}" class="text-blue-600 hover:underline">Cuentas por Cobrar</a>
                                </p>
                            </div>
                            @endcan

                        @else
                            {{-- PAGADO: Mostrar información del documento --}}
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-lg p-4 text-center">
                                <div class="text-3xl mb-2">✅</div>
                                <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                                    Mensualidad Pagada
                                </p>
                                @if($item->venta)
                                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                                        {{ $item->venta->serie_numero }}
                                    </p>
                                @elseif($item->recibo)
                                    <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mt-1">
                                        {{ $item->recibo->serie_numero }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                    Próximo vencimiento: {{ $item->fecha->format('d/m/Y') }}
                                </p>
                            </div>
                        @endif
                    @else
                        {{-- VEHÍCULO SUSPENDIDO --}}
                        <div class="bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-700 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Vehículo suspendido
                            </p>
                        </div>
                    @endif
                </div>

                @if ($cobro->comentario)
                    <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg">
                        <p class="text-xs text-gray-600 dark:text-gray-400 italic">{{ $cobro->comentario }}</p>
                    </div>
                @endif
            </div>
        @endforeach

        @if ($cobro->detalle->count() < 1)
            <div class="col-span-full">
                <div
                    class="bg-white dark:bg-gray-800 p-8 shadow-xs rounded-xl border border-gray-200 dark:border-gray-700/60 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">No hay detalles de cobranza registrados</p>
                </div>
            </div>
        @endif
    </div>

    {{-- PAGOS REALIZADOS --}}
    @if ($cobro->payments && $cobro->payments->count() > 0)
        <div class="mt-8">
            <div
                class="bg-white dark:bg-gray-800 shadow-xs rounded-xl border border-gray-200 dark:border-gray-700/60 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700/60 bg-gray-50 dark:bg-gray-900/20">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Pagos Realizados</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $cobro->payments->count() }}
                        {{ $cobro->payments->count() == 1 ? 'pago registrado' : 'pagos registrados' }}</p>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700/60">
                    @foreach ($cobro->payments as $payment)
                        <div
                            class="flex items-center gap-4 p-6 hover:bg-gray-100/50 dark:hover:bg-gray-700/30 transition-colors">
                            <div class="shrink-0">
                                <div
                                    class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/40 rounded-full flex items-center justify-center border border-emerald-200 dark:border-emerald-800">
                                    <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-1">
                                    Pago del Documento <span
                                        class="text-emerald-600 dark:text-emerald-400">{{ $payment->paymentable->serie_numero }}</span>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    Realizado en <span
                                        class="font-semibold text-gray-900 dark:text-white">{{ $payment->paymentMethod->descripcion }}</span>
                                    con operación <span
                                        class="font-semibold text-gray-900 dark:text-white">#{{ $payment->numero_operacion }}</span>
                                </p>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="px-2 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700/50 rounded">N°
                                        {{ $payment->numero }}</span>
                                    <span
                                        class="px-3 py-1 text-sm font-semibold bg-emerald-100 dark:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 rounded-full border border-emerald-200 dark:border-emerald-800">
                                        {{ $payment->paymentable->divisa }} {{ number_format($payment->monto, 2) }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $payment->fecha->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- COMPONENTE FACTURAR Y COBRAR (desactivado - ahora usa redirect a Emitir/Create) --}}
    {{-- @livewire('admin.cobros.facturar-y-cobrar') --}}
</div>
