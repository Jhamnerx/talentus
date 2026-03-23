<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    <!-- Header con estadísticas -->
    <div class="mb-8">
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Notificaciones de Cobro 🔔
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Cobros próximos a facturar generados automáticamente
                </p>
            </div>
            <div>
                <button wire:click="abrirModalGenerarNotificaciones"
                    class="btn bg-indigo-600 hover:bg-indigo-700 cursor-pointer text-white flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Generar notificaciones
                </button>
            </div>

        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
            <!-- Pendientes -->
            <div class="bg-linear-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Pendientes</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['pendientes'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Vencidos -->
            <div class="bg-linear-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Vencidos</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['vencidos'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Para Hoy -->
            <div class="bg-linear-to-br from-amber-500 to-amber-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm font-medium">Para Hoy</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $stats['hoy'] }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monto Pendiente PEN -->
            <div class="bg-linear-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Pendiente (S/.)</p>
                        <p class="text-white text-2xl font-bold mt-1">S/.
                            {{ number_format($stats['monto_pendiente_pen'], 2) }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Monto Pendiente USD -->
            <div class="bg-linear-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-teal-100 text-sm font-medium">Pendiente (USD)</p>
                        <p class="text-white text-2xl font-bold mt-1">USD
                            {{ number_format($stats['monto_pendiente_usd'], 2) }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros compactos -->
        <div class="grid grid-cols-12 gap-2 items-center">

            <!-- Búsqueda -->
            <div class="col-span-12 sm:col-span-4 relative">
                <input wire:model.live.debounce="search" type="search"
                    class="form-input pl-8 py-1.5 text-sm w-full dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    placeholder="Cliente, placa..." />
                <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-gray-400 pointer-events-none fill-current"
                    viewBox="0 0 16 16">
                    <path
                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                    <path
                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                </svg>
            </div>

            <!-- Cliente -->
            <div class="col-span-12 sm:col-span-3">
                <x-form.select wire:model.live="clienteId" placeholder="Todos los clientes" sm>
                    <x-select.option label="Todos los clientes" value="" />
                    @foreach ($this->clientes as $cliente)
                        <x-select.option label="{{ $cliente->razon_social }}" value="{{ $cliente->id }}" />
                    @endforeach
                </x-form.select>
            </div>

            <!-- Estado -->
            <div class="col-span-6 sm:col-span-2">
                <x-form.select wire:model.live="estado" placeholder="Estado" sm>
                    <x-select.option label="Todos" value="" />
                    <x-select.option label="⏳ Pendiente" value="PENDIENTE" />
                    <x-select.option label="📄 Facturado" value="FACTURADO" />
                    <x-select.option label="✅ Pagado" value="PAGADO" />
                    <x-select.option label="❌ Cancelado" value="CANCELADO" />
                </x-form.select>
            </div>

            <!-- Vencimiento -->
            <div class="col-span-6 sm:col-span-2">
                <x-form.select wire:model.live="filtroVencimiento" placeholder="Vencimiento" sm>
                    <x-select.option label="Todo" value="" />
                    <x-select.option label="🔴 Vencidos" value="vencidos" />
                    <x-select.option label="📅 Hoy" value="hoy" />
                    <x-select.option label="🟡 7 días" value="7dias" />
                    <x-select.option label="🟢 15 días" value="15dias" />
                </x-form.select>
            </div>

            <!-- Per Page + Limpiar -->
            <div class="col-span-12 sm:col-span-1 flex items-center gap-2">
                <x-form.select wire:model.live="perPage" sm :clearable="false">
                    <x-select.option label="10" value="10" />
                    <x-select.option label="15" value="15" />
                    <x-select.option label="25" value="25" />
                    <x-select.option label="50" value="50" />
                </x-form.select>

                @if ($search || $clienteId || $estado || $filtroVencimiento)
                    <button wire:click="clearFilters" title="Limpiar filtros"
                        class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-100 hover:bg-rose-200 dark:bg-rose-900/40 dark:hover:bg-rose-900/60 text-rose-600 dark:text-rose-400 transition">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 16 16">
                            <path
                                d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                        </svg>
                    </button>
                @endif
            </div>

        </div>
    </div>

    <!-- Tabla de notificaciones -->
    @php
        $pendienteIdsEnPagina = $notificaciones->where('estado', 'PENDIENTE')->pluck('id')->toArray();
    @endphp
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto min-h-screen">
            <table class="table-auto w-full dark:text-gray-300">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-b border-gray-200 dark:border-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap" x-data="{ pageIds: @js($pendienteIdsEnPagina) }">
                            <input type="checkbox"
                                class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer"
                                :checked="pageIds.length > 0 && pageIds.every(id => $wire.notificacionesSeleccionadas.map(Number)
                                    .includes(id))"
                                :indeterminate.prop="pageIds.some(id => $wire.notificacionesSeleccionadas.map(Number).includes(id)) && !
                                    pageIds.every(id => $wire.notificacionesSeleccionadas.map(Number).includes(id))"
                                @change="$el.checked ? $wire.seleccionarIds(pageIds) : $wire.deseleccionarIds(pageIds)"
                                title="Seleccionar todos en esta página">
                        </th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vencimiento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Cliente</th>

                        <th class="px-4 py-3 whitespace-nowrap text-left">Vehículo</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Descripción</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Tipo</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right">Monto</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Documento</th>
                        <th class="px-4 py-3 whitespace-nowrap text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700/60">
                    @forelse ($notificaciones as $notificacion)
                        <tr wire:key="notif-{{ $notificacion->id }}"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700/30 {{ in_array($notificacion->id, $notificacionesSeleccionadas) ? 'bg-indigo-50 dark:bg-indigo-900/20' : '' }}">
                            <!-- Checkbox selección -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->estado === 'PENDIENTE')
                                    <input type="checkbox"
                                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer"
                                        wire:click="toggleSeleccion({{ $notificacion->id }}, {{ $notificacion->cliente_id }})"
                                        :checked="$wire.notificacionesSeleccionadas.map(Number).includes({{ $notificacion->id }})">
                                @endif
                            </td>
                            <!-- Estado -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->estado === 'PENDIENTE')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-300 rounded-full">
                                        ⏳ Pendiente
                                    </span>
                                @elseif($notificacion->estado === 'FACTURADO')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 rounded-full">
                                        📄 Facturado
                                    </span>
                                @elseif($notificacion->estado === 'PAGADO')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-full">
                                        ✅ Pagado
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-300 rounded-full">
                                        ❌ Cancelado
                                    </span>
                                @endif
                            </td>

                            <!-- Vencimiento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->fecha_vencimiento->format('d/m/Y') }}
                                </div>
                                @if (in_array($notificacion->estado, ['PENDIENTE', 'FACTURADO']))
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        @if ($notificacion->fecha_vencimiento->isToday())
                                            Hoy
                                        @elseif($notificacion->fecha_vencimiento->isPast())
                                            🔴 Vencido hace {{ $notificacion->fecha_vencimiento->diffForHumans() }}
                                        @else
                                            Vence {{ $notificacion->fecha_vencimiento->diffForHumans() }}
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <!-- Cliente -->
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->cliente->razon_social }}
                                </div>
                            </td>

                            <!-- Vehículo -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->vehiculo)
                                    <span
                                        class="px-2 py-1 text-xs font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded">
                                        {{ $notificacion->vehiculo->placa }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">Sin vehículo</span>
                                @endif
                            </td>

                            <!-- Descripción -->
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                    {{ $notificacion->descripcion }}
                                </div>
                                @if ($notificacion->fecha_inicio || $notificacion->fecha_fin)
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                        {{ $notificacion->fecha_inicio?->format('d/m/Y') ?? '—' }}
                                        →
                                        {{ $notificacion->fecha_fin?->format('d/m/Y') ?? '—' }}
                                    </div>
                                @endif
                            </td>
                            <!-- Tipo de Pago -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php $tipoPago = $notificacion->cobro?->tipo_pago; @endphp
                                @if ($tipoPago === 'FACTURA')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300 rounded-full">Factura</span>
                                @elseif($tipoPago === 'BOLETA')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-violet-100 dark:bg-violet-900/50 text-violet-800 dark:text-violet-300 rounded-full">Boleta</span>
                                @elseif($tipoPago === 'RECIBO')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-full">Recibo</span>
                                @else
                                    <span class="text-xs text-gray-400">{{ $tipoPago ?? '—' }}</span>
                                @endif
                            </td>
                            <!-- Monto -->
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $notificacion->moneda }} {{ number_format($notificacion->monto, 4) }}
                                </span>
                            </td>

                            <!-- Documento -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notificacion->venta)
                                    <a target="_blank"
                                        href="{{ route('facturacion.ver.pdf', $notificacion->venta) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Venta
                                        #{{ $notificacion->venta->serie_correlativo ?? $notificacion->venta->id }}
                                    </a>
                                @elseif($notificacion->recibo)
                                    <a target="_blank" href="{{ route('admin.pdf.recibo', $notificacion->recibo) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline text-xs">
                                        Recibo #{{ $notificacion->recibo->serie_numero ?? $notificacion->recibo->id }}
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">Sin documento</span>
                                @endif
                            </td>

                            <!-- Acciones -->
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                @if ($notificacion->estado === 'PENDIENTE')
                                    <x-form.dropdown>
                                        <x-dropdown.item icon="currency-dollar" label="Registrar pago"
                                            wire:click.prevent="abrirModalPago({{ $notificacion->id }})" />
                                        <x-dropdown.item icon="document-text" label="Emitir documento"
                                            wire:click.prevent="redirectToFacturar({{ $notificacion->id }})" />
                                        <x-dropdown.item icon="x-circle" label="Cancelar"
                                            wire:click.prevent="cancelar({{ $notificacion->id }})" />
                                    </x-form.dropdown>
                                @elseif($notificacion->estado === 'FACTURADO')
                                    {{-- Documento emitido, pendiente de pago --}}
                                    @if ($notificacion->venta)
                                        <a target="_blank"
                                            href="{{ route('facturacion.ver.pdf', $notificacion->venta) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition">
                                            📄 Ver documento
                                        </a>
                                    @elseif($notificacion->recibo)
                                        <a target="_blank"
                                            href="{{ route('admin.pdf.recibo', $notificacion->recibo) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition">
                                            📄 Ver documento
                                        </a>
                                    @endif
                                @elseif($notificacion->estado === 'PAGADO')
                                    {{-- Mostrar datos del pago como tooltip flotante --}}
                                    @php
                                        $paymentable = $notificacion->venta ?? $notificacion->recibo;
                                        $payment = $paymentable?->payments->first();
                                    @endphp
                                    @if ($payment)
                                        <div class="relative inline-flex justify-center" x-data="{ open: false }"
                                            @mouseenter="open = true" @mouseleave="open = false">
                                            <button
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-lg bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-900/60 transition">
                                                ✅ Ver pago
                                            </button>
                                            <div class="absolute top-full mt-2 left-1/2 -translate-x-1/2 z-20"
                                                x-show="open" x-transition:enter="transition ease-out duration-150"
                                                x-transition:enter-start="opacity-0 translate-y-1"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-out duration-100"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" x-cloak>
                                                <div
                                                    class="min-w-40 p-3 rounded-xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-200 dark:border-gray-700 text-left space-y-1.5">
                                                    <div
                                                        class="text-xs font-semibold text-gray-800 dark:text-gray-100">
                                                        {{ $payment->paymentMethod->description ?? 'Pago' }}
                                                    </div>
                                                    <div
                                                        class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                        {{ $payment->divisa }} {{ number_format($payment->monto, 2) }}
                                                    </div>
                                                    @if ($payment->fecha)
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                                            {{ \Carbon\Carbon::parse($payment->fecha)->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                    @if ($payment->numero_operacion)
                                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                                            Op: {{ $payment->numero_operacion }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">Pagado</span>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="font-medium">No hay notificaciones con los filtros aplicados</p>
                                <p class="text-sm mt-1">Intenta cambiar los filtros o crear nuevos cobros</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if ($notificaciones->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700/60">
                {{ $notificaciones->links() }}
            </div>
        @endif
    </div>
    {{-- Barra flotante de acción múltiple --}}
    @if (!empty($notificacionesSeleccionadas))
        <div
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 px-5 py-3 bg-gray-900 dark:bg-gray-700 text-white rounded-2xl shadow-2xl">
            <span class="text-sm font-medium">
                {{ count($notificacionesSeleccionadas) }} seleccionada(s)
            </span>
            <button wire:click="redirectToFacturarSeleccionadas" wire:loading.attr="disabled"
                wire:target="redirectToFacturarSeleccionadas"
                class="flex items-center gap-1.5 px-4 py-1.5 text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-600 disabled:opacity-60 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span wire:loading.remove wire:target="redirectToFacturarSeleccionadas">Facturar seleccionadas</span>
                <span wire:loading wire:target="redirectToFacturarSeleccionadas">Procesando...</span>
            </button>
            <button wire:click="deseleccionarTodos"
                class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-700 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-500 transition">
                Cancelar
            </button>
        </div>
    @endif

    {{-- Modal: Generar Notificaciones de Cobro --}}
    <x-form.modal.card title="GENERAR NOTIFICACIONES DE COBRO" wire:model.live="modalGenerarNotif" max-width="sm"
        blur>
        <div class="px-4 py-4">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Genera notificaciones para los cobros que vencen en los próximos <strong>N días</strong>.
                Máximo permitido: <strong>15 días</strong>.
            </p>
            <x-form.input wire:model.defer="generarDias" label="Días de anticipación" type="number" min="1"
                max="15" placeholder="7" />
            @error('generarDias')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cancelar" wire:click="$set('modalGenerarNotif', false)" />
                <x-form.button primary label="Ejecutar" wire:click="ejecutarGenerarNotificaciones"
                    wire:loading.attr="disabled" wire:target="ejecutarGenerarNotificaciones">
                    <x-slot name="prepend">
                        <svg wire:loading wire:target="ejecutarGenerarNotificaciones"
                            class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </x-slot>
                </x-form.button>
            </div>
        </x-slot>
    </x-form.modal.card>

    {{-- Modal: Registrar Pago Directo (mismo patron que payment.blade.php) --}}
    <x-form.modal.card title="REGISTRAR PAGO" wire:model.live="modalPago" max-width="2xl" blur>

        <form autocomplete="off">
            <div class="px-4 py-4 grid grid-cols-12 gap-4">

                {{-- Modo: Crear vs Asociar --}}
                <div class="col-span-12">
                    <div class="flex items-center justify-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Modo:</span>
                        <x-form.button :primary="$pago_mode === 'create'" :flat="$pago_mode !== 'create'" label="Nuevo Pago"
                            wire:click="$set('pago_mode', 'create')" sm />
                        <x-form.button :primary="$pago_mode === 'associate'" :flat="$pago_mode !== 'associate'" label="Asociar Existente"
                            wire:click="$set('pago_mode', 'associate')" sm />
                    </div>
                </div>

                @if ($pago_mode === 'associate')

                    {{-- Selector de pago existente --}}
                    <div class="col-span-12">
                        <x-form.select wire:model.defer="pago_existing_id" label="Selecciona el Pago a Asociar"
                            placeholder="Busca un pago existente...">
                            @forelse ($pago_existing_list as $ep)
                                <x-select.option label="{{ $ep['label'] }}" value="{{ $ep['id'] }}" />
                            @empty
                                <x-select.option label="No hay pagos disponibles para asociar" value=""
                                    disabled />
                            @endforelse
                        </x-form.select>
                        @if (count($pago_existing_list) === 0)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                No hay pagos sin cobro asociado disponibles para este cliente.
                            </p>
                        @endif
                    </div>
                @else
                    {{-- Número (auto-generado, solo lectura) --}}
                    <div class="col-span-12 sm:col-span-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Número: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model.live="pago_numero" disabled
                            class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
                    </div>

                    {{-- Tipo de pago --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.select wire:model.live="pago_tipo_pago" label="Tipo Pago" :options="[
                            ['value' => 'FACTURA', 'label' => 'FACTURA'],
                            ['value' => 'RECIBO', 'label' => 'RECIBO'],
                        ]"
                            option-value="value" option-label="label" :clearable="false" />
                    </div>

                    {{-- Documento asociado (factura/boleta o recibo) --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.select wire:model.live="pago_paymentable_id" label="{{ $pago_titulo_doc }}"
                            placeholder="Selecciona">
                            @foreach ($pago_documentos as $doc)
                                <x-select.option label="{{ $doc['text'] }}" value="{{ $doc['id'] }}" />
                            @endforeach
                        </x-form.select>
                    </div>

                    {{-- Método de pago --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.select label="Método de Pago" wire:model.live="pago_payment_method_id"
                            placeholder="Seleccione un método" :options="$paymentMethods" option-label="description"
                            option-value="id" />
                    </div>

                    {{-- Destino del pago (caja / banco) --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.select label="Destino del Pago" wire:model.defer="pago_payment_destination_id"
                            placeholder="Seleccione destino">
                            @foreach ($this->paymentDestinations as $dest)
                                <x-select.option label="{{ $dest['description'] }}" value="{{ $dest['id'] }}" />
                            @endforeach
                        </x-form.select>
                    </div>

                    {{-- Cuenta bancaria (solo si metodo es deposito) --}}
                    @if ($pago_showBankAccountSelector)
                        <div class="col-span-12 sm:col-span-6">
                            <x-form.select label="Cuenta Bancaria" wire:model.defer="pago_bank_account_id"
                                placeholder="Seleccione cuenta">
                                @foreach ($bankAccounts as $account)
                                    <x-select.option label="{{ $account->description ?? $account->number }}"
                                        value="{{ $account->id }}" />
                                @endforeach
                            </x-form.select>
                        </div>
                    @endif

                    {{-- Divisa --}}
                    <div class="col-span-6 sm:col-span-3">
                        <x-form.select wire:model.live="pago_divisa" label="Divisa" :options="[
                            ['value' => 'PEN', 'label' => 'PEN (Soles)'],
                            ['value' => 'USD', 'label' => 'USD (Dólares)'],
                        ]"
                            option-value="value" option-label="label" :clearable="false" />
                    </div>

                    {{-- Monto --}}
                    <div class="col-span-6 sm:col-span-3">
                        <x-form.currency label="Monto" wire:model.blur="pago_monto" thousands="," decimal="."
                            precision="4" />
                        @error('pago_monto')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.datetime.picker label="Fecha" wire:model.defer="pago_fecha" without-time
                            parse-format="YYYY-MM-DD" />
                    </div>

                    {{-- Número de operación --}}
                    <div class="col-span-12 sm:col-span-6">
                        <x-form.input label="Número de operación" wire:model.defer="pago_numero_operacion"
                            placeholder="45474001" />
                    </div>

                    {{-- Nota --}}
                    <div class="col-span-12">
                        <x-form.textarea label="Nota" wire:model.defer="pago_nota"
                            placeholder="Observaciones opcionales..." rows="3" />
                    </div>

                @endif {{-- fin modo crear --}}

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="cerrarModalPago" />
                <x-form.button primary label="Guardar" wire:click="confirmarPago" wire:loading.attr="disabled"
                    wire:target="confirmarPago" />
            </div>
        </x-slot>

    </x-form.modal.card>

</div>
