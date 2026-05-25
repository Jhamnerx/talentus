<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Órdenes de Trabajo</h1>
        </div>
        {{-- Estado dispositivo interno WhatsApp para notificaciones --}}
        <div class="flex items-center gap-2">
            <div
                class="flex items-center gap-2 px-3 py-2 rounded-lg
                {{ $waDevice && $waDevice->status === 'Connected'
                    ? 'bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-700'
                    : 'bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-700' }}">
                <span
                    class="inline-block w-2.5 h-2.5 rounded-full {{ $waDevice && $waDevice->status === 'Connected' ? 'bg-emerald-500 animate-pulse' : 'bg-red-400' }}"></span>
                <span
                    class="text-xs font-medium {{ $waDevice && $waDevice->status === 'Connected' ? 'text-emerald-700 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                    WA:
                    {{ $waDevice && $waDevice->status === 'Connected' ? 'Conectado' : ($waDevice ? 'Desconectado' : 'Sin dispositivo') }}
                </span>
                @if ($waDevice)
                    <span class="text-xs text-gray-400 dark:text-gray-500">({{ $waDevice->body }})</span>
                @endif
                @if (!$waDevice || $waDevice->status !== 'Connected')
                    <a href="{{ route('admin.whats-fleep.devices') }}"
                        class="text-xs underline text-blue-600 dark:text-blue-400">Conectar</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Pendientes --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="shrink-0 p-3 rounded-md bg-yellow-100 dark:bg-yellow-900">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                Pendientes
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $stats['pendientes'] }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- En Proceso --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="shrink-0 p-3 rounded-md bg-blue-100 dark:bg-blue-900">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                En Proceso
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $stats['en_proceso'] }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- Finalizadas --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="shrink-0 p-3 rounded-md bg-green-100 dark:bg-green-900">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                Finalizadas
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $stats['finalizadas'] }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        {{-- Canceladas --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="shrink-0 p-3 rounded-md bg-red-100 dark:bg-red-900">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                Canceladas
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $stats['canceladas'] }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Botón Crear y Exportar --}}
    <div class="mb-6 flex gap-3">
        <x-form.button primary label="Nueva Orden de Trabajo" wire:click="openCreateModal" icon="plus" />
        <x-form.button secondary label="Exportar a Excel" wire:click="abrirModalExport" icon="document-arrow-down" />
    </div>

    {{-- Filtros --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <x-form.input wire:model.live.debounce.300ms="search" placeholder="Buscar por código, placa..."
                icon="magnifying-glass" />

            <x-form.select wire:model.live="estado_filter" placeholder="Todos los estados">
                <x-select.option value="">Todos</x-select.option>
                <x-select.option value="pendiente">Pendiente</x-select.option>
                <x-select.option value="en_proceso">En Proceso</x-select.option>
                <x-select.option value="finalizado">Finalizado</x-select.option>
                <x-select.option value="cancelado">Cancelado</x-select.option>
            </x-form.select>

            <x-form.datetime.picker wire:model.live="fecha_desde" placeholder="Fecha desde" without-time />
            <x-form.datetime.picker wire:model.live="fecha_hasta" placeholder="Fecha hasta" without-time />
        </div>

        @if ($search || $estado_filter || $fecha_desde || $fecha_hasta)
            <div class="mt-4">
                <x-form.button wire:click="limpiarFiltros" flat label="Limpiar filtros" icon="x-mark" />
            </div>
        @endif
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipo
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Vehículo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Técnico</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Fecha
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                        Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($ordenes as $orden)
                    <tr wire:key="orden-{{ $orden->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $orden->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $orden->tipo->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @if ($orden->es_proyecto)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    {{ $orden->items_count ?? $orden->items->count() }} unidades
                                </span>
                            @else
                                {{ $orden->vehiculo?->placa ?? '—' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @if ($orden->es_proyecto)
                                <span
                                    class="text-indigo-600 dark:text-indigo-400 font-medium">{{ Str::limit($orden->titulo_proyecto ?? 'Proyecto', 30) }}</span>
                            @else
                                {{ Str::limit($orden->cliente?->razon_social ?? '—', 30) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $orden->tecnico->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $orden->fecha_programada->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $orden->estado->statusColor() }}">
                                {{ $orden->estado->label() }}
                            </span>
                            @if ($orden->verification_status === 'verified')
                                <div class="mt-1 inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300"
                                    title="Verificado por el cliente el {{ $orden->verified_at?->format('d/m/Y H:i') }}">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Verificado
                                </div>
                            @elseif ($orden->verification_status === 'rejected')
                                <div class="mt-1 inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300"
                                    title="Problema reportado el {{ $orden->verified_at?->format('d/m/Y H:i') }}{{ $orden->verification_notes ? ': ' . $orden->verification_notes : '' }}">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                    </svg>
                                    Problema
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @php
                                try {
                                    $mensajeWA = app(\App\Services\WorkOrderNotificationService::class)->formatMensaje(
                                        $orden,
                                    );
                                } catch (\Throwable $e) {
                                    $mensajeWA = '';
                                }
                                $verificationUrl = $orden->verification_hash
                                    ? config('app.talentus_web_url', '') .
                                        '/verificar-orden/' .
                                        $orden->verification_hash
                                    : '';
                                $verificationMsg = $verificationUrl
                                    ? "✅ *Orden de Trabajo Finalizada*\n\n📋 *Tipo:* {$orden->tipo?->nombre}\n" .
                                        ($orden->es_proyecto
                                            ? "📦 *Proyecto:* {$orden->titulo_proyecto}\n"
                                            : ($orden->cliente?->razon_social
                                                    ? "👤 *Cliente:* {$orden->cliente->razon_social}\n"
                                                    : '') .
                                                ($orden->vehiculo?->placa
                                                    ? "🚗 *Vehículo:* {$orden->vehiculo->placa}\n"
                                                    : '')) .
                                        "\nPuede revisar y verificar el servicio realizado en el siguiente enlace:\n🔗 {$verificationUrl}"
                                    : '';
                            @endphp
                            <div class="flex items-center gap-1" x-data="{ copiadoWA: false, copiadoLink: false }">

                                {{-- Ver detalle --}}
                                <x-form.button xs icon="eye" wire:click="verDetalle({{ $orden->id }})" flat
                                    title="Ver detalle" />

                                {{-- Iniciar (solo pendiente) --}}
                                @if ($orden->estado->value === 'pendiente')
                                    <x-form.button xs icon="play" wire:click="iniciarOrden({{ $orden->id }})"
                                        primary title="Iniciar orden" />
                                @endif

                                {{-- Eliminar (solo pendiente sin relaciones, admin) --}}
                                @if ($orden->estado->value === 'pendiente' && auth()->user()->hasRole('admin'))
                                    @if ($eliminarOrdenId === $orden->id)
                                        <span class="inline-flex items-center gap-0.5">
                                            <button wire:click="eliminarOrden({{ $orden->id }})"
                                                title="Confirmar eliminación"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded text-white bg-red-600 hover:bg-red-700 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                            <button wire:click="$set('eliminarOrdenId', null)" title="Cancelar"
                                                class="inline-flex items-center justify-center w-7 h-7 rounded text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </span>
                                    @else
                                        <button wire:click="$set('eliminarOrdenId', {{ $orden->id }})"
                                            title="Eliminar orden"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                @endif

                                {{-- Cancelar (admin, si no está bloqueada ni ya cancelada) --}}
                                @if (auth()->user()->hasRole('admin') && !$orden->bloqueado && $orden->estado->value !== 'cancelado')
                                    <button wire:click="abrirModalCancelar({{ $orden->id }})"
                                        title="Cancelar orden"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded text-orange-500 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Enviar / Reenviar WA al técnico (pendiente/en_proceso) --}}
                                @if (in_array($orden->estado->value, ['pendiente', 'en_proceso']))
                                    <button wire:click="reenviarNotificacionWA({{ $orden->id }})"
                                        title="{{ $orden->wa_message_id ? 'Reenviar notificación WA (ya enviada)' : 'Enviar notificación WA al técnico' }}"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded {{ $orden->wa_message_id ? 'text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' : 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' }} transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448L0 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Copiar mensaje WA para el técnico --}}
                                @if ($mensajeWA)
                                    <button
                                        @click="
                                            const copiar = (t) => {
                                                if (navigator.clipboard && window.isSecureContext) return navigator.clipboard.writeText(t);
                                                const ta = document.createElement('textarea');
                                                ta.value = t; ta.style.cssText = 'position:fixed;opacity:0';
                                                document.body.appendChild(ta); ta.focus(); ta.select();
                                                document.execCommand('copy'); document.body.removeChild(ta);
                                                return Promise.resolve();
                                            };
                                            copiar(@js($mensajeWA)).then(() => { copiadoWA = true; setTimeout(() => copiadoWA = false, 2500); });
                                        "
                                        :title="copiadoWA ? '¡Copiado!' : 'Copiar mensaje WA al técnico'"
                                        :class="copiadoWA ? 'text-emerald-600 bg-emerald-50' :
                                            'text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-900/20'"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded transition cursor-pointer">
                                        <svg x-show="!copiadoWA" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <svg x-show="copiadoWA" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif

                                {{-- Descargar PDF --}}
                                @if (in_array($orden->estado->value, ['finalizado', 'cancelado']) || $orden->bloqueado)
                                    <a href="{{ route('admin.work-orders.pdf', $orden) }}" target="_blank"
                                        title="Descargar PDF de la orden"
                                        class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        PDF
                                    </a>
                                @endif

                                {{-- Copiar enlace de verificación para el cliente --}}
                                @if ($verificationMsg)
                                    <button
                                        @click="
                                            const copiar = (t) => {
                                                if (navigator.clipboard && window.isSecureContext) return navigator.clipboard.writeText(t);
                                                const ta = document.createElement('textarea');
                                                ta.value = t; ta.style.cssText = 'position:fixed;opacity:0';
                                                document.body.appendChild(ta); ta.focus(); ta.select();
                                                document.execCommand('copy'); document.body.removeChild(ta);
                                                return Promise.resolve();
                                            };
                                            copiar(@js($verificationMsg)).then(() => { copiadoLink = true; setTimeout(() => copiadoLink = false, 2500); });
                                        "
                                        :title="copiadoLink ? '¡Copiado!' : 'Copiar enlace de verificación para el cliente'"
                                        :class="copiadoLink ? 'text-emerald-600 bg-emerald-50' :
                                            'text-violet-600 hover:bg-violet-50 dark:hover:bg-violet-900/20'"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded transition cursor-pointer">
                                        <svg x-show="!copiadoLink" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                        <svg x-show="copiadoLink" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endif

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron órdenes de trabajo
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $ordenes->links() }}
        </div>
    </div>

    {{-- Sección de Tipos de Órdenes --}}
    <div class="mt-8">
        <div class="sm:flex sm:justify-between sm:items-center mb-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Tipos de Órdenes de Trabajo</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configuración de tipos de órdenes disponibles
                </p>
            </div>
            <div>
                <x-form.button primary label="Crear Tipo Orden" wire:click="crearTipo" icon="plus" />
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Costo Base</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Total Órdenes</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Requisitos</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Estado</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tipos as $tipo)
                        <tr wire:key="tipo-{{ $tipo->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $tipo->nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $tipo->descripcion ? Str::limit($tipo->descripcion, 60) : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                S/ {{ number_format($tipo->costo_base, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $tipo->work_orders_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-wrap justify-center gap-1">
                                    @if ($tipo->requiere_imei)
                                        <span
                                            class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200"
                                            title="Requiere IMEI">IMEI</span>
                                    @endif
                                    @if ($tipo->requiere_sim)
                                        <span
                                            class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200"
                                            title="Requiere SIM">SIM</span>
                                    @endif
                                    @if ($tipo->requiere_accesorios)
                                        <span
                                            class="px-2 py-1 text-xs rounded bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200"
                                            title="Requiere Accesorios">ACC</span>
                                    @endif
                                    @if ($tipo->requiere_checklist)
                                        <span
                                            class="px-2 py-1 text-xs rounded bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200"
                                            title="Requiere Lista de Verificación">CHK</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($tipo->active)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 text-center">
                                <x-form.button xs flat icon="pencil" wire:click="editarTipo({{ $tipo->id }})"
                                    teal />

                                <x-form.button xs flat icon="{{ $tipo->active ? 'eye-slash' : 'eye' }}"
                                    wire:click="toggleActivoTipo({{ $tipo->id }})"
                                    {{ $tipo->active ? 'orange' : 'green' }} />

                                @if ($tipo->work_orders_count == 0)
                                    <x-form.button xs flat icon="trash"
                                        wire:click="eliminarTipo({{ $tipo->id }})"
                                        wire:confirm="¿Eliminar el tipo '{{ $tipo->nombre }}'?" negative />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No hay tipos de órdenes registrados.
                                <button wire:click="crearTipo"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                    Crear el primero
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal para Crear/Editar Tipo (Componente separado) --}}
    @livewire('admin.work-orders.types.create')

    {{-- ══════════════════════════════════════════════════════════════════════
         Configuración de Técnicos — WhatsApp (solo admin)
    ══════════════════════════════════════════════════════════════════════════ --}}
    @role('admin')
        <div class="mt-8">
            <div class="sm:flex sm:justify-between sm:items-center mb-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">Configuración de Técnicos — WhatsApp
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Asigna ciudad y grupo de WhatsApp a cada
                        técnico. Las notificaciones se env&iacute;an desde <strong>tu dispositivo conectado</strong> al
                        grupo asignado al t&eacute;cnico.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Técnico</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Ciudad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Grupo WhatsApp</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Tu dispositivo WA</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                                Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($tecnicos as $tecnico)
                            <tr wire:key="tec-{{ $tecnico->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $tecnico->profile_photo_url }}" alt=""
                                            class="w-7 h-7 rounded-full object-cover" />
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $tecnico->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $tecnico->ciudad?->nombre ?? '—' }}
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm">
                                    @if ($tecnico->wa_group_id)
                                        <span
                                            class="font-mono text-xs text-gray-600 dark:text-gray-400">{{ $tecnico->wa_group_id }}</span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 italic text-xs">Sin configurar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    @if ($tecnico->wa_conectado)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Conectado
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Sin sesión
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <x-form.button xs flat icon="pencil"
                                        wire:click="abrirConfigTecnico({{ $tecnico->id }})" teal />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-6 text-center text-gray-400 dark:text-gray-500 text-sm italic">
                                    No hay técnicos registrados con el rol "tecnico".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Configuración Técnico --}}
        <x-form.modal.card title="Configurar Técnico — WhatsApp" wire:model.live="modalTecnicoConfig" max-width="lg">
            <div class="space-y-4">
                <x-form.select label="Ciudad del técnico" wire:model.live="tecnicoConfigCiudad"
                    wire:key="ciudad-select-{{ $tecnicoConfigId }}" placeholder="Sin ciudad asignada" :clearable="true">
                    @foreach ($ciudades as $ciudad)
                        <x-select.option value="{{ $ciudad->id }}" label="{{ $ciudad->nombre }}" />
                    @endforeach
                </x-form.select>

                <div>
                    <x-form.input label="ID del grupo de WhatsApp" wire:model.live="tecnicoConfigGrupo"
                        placeholder="Ej: 120363xxxxxxxxxx@g.us" />
                    @if ($waGroups->isNotEmpty())
                        <div class="mt-2">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Grupos disponibles en tu dispositivo:
                            </p>
                            <div
                                class="max-h-36 overflow-y-auto space-y-1 border border-gray-200 dark:border-gray-600 rounded p-2">
                                @foreach ($waGroups as $grupo)
                                    <button type="button"
                                        wire:click="$set('tecnicoConfigGrupo', '{{ $grupo->group_id }}')"
                                        class="w-full text-left text-xs px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 truncate">
                                        {{ $grupo->name }}
                                        <span class="text-gray-400 ml-1">({{ $grupo->group_id }})</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">
                            Sin grupos sincronizados. Ve a <a href="{{ route('admin.whats-fleep.contacts.groups') }}"
                                class="underline">Grupos WA</a> para sincronizar.
                        </p>
                    @endif
                </div>
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-form.button flat label="Cancelar" wire:click="$set('modalTecnicoConfig', false)" />
                    <x-form.button primary label="Guardar" wire:click="guardarConfigTecnico"
                        spinner="guardarConfigTecnico" />
                </div>
            </x-slot>
        </x-form.modal.card>
    @endrole

    {{-- Modal: Cancelar Orden --}}
    <x-form.modal.card title="Cancelar Orden de Trabajo" wire:model="modalCancelar" blur>
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                <svg class="w-5 h-5 text-orange-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm text-orange-700 dark:text-orange-300">
                    Esta acción cancelará y bloqueará la orden de trabajo permanentemente. No podrá ser reabierta.
                </p>
            </div>
            <x-form.textarea wire:model="motivoCancelacion" label="Motivo de cancelación"
                placeholder="Describe el motivo por el que se cancela esta orden..." rows="3" required />
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="$set('modalCancelar', false)" />
                <x-form.button negative label="Confirmar cancelación" wire:click="cancelarOrden"
                    spinner="cancelarOrden" icon="no-symbol" />
            </div>
        </x-slot>
    </x-form.modal.card>

</div>
