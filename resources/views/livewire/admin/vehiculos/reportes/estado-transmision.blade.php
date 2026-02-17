<div>
    <x-form.modal.card title="Estado de Transmisión GPS" blur wire:model="openModalEstadoTransmision" width="7xl"
        persistent>

        <!-- Header con resumen y botón refrescar -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                @if ($estadoData)
                    <div class="text-sm">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Total dispositivos:</span>
                        <span
                            class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $estadoData['total_active_devices'] }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-500/20 text-emerald-800 dark:text-emerald-400">
                            OK: {{ $estadoData['summary']['ok'] }}
                        </span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 dark:bg-amber-500/20 text-amber-800 dark:text-amber-400">
                            Advertencia: {{ $estadoData['summary']['warning'] }}
                        </span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-500/20 text-orange-800 dark:text-orange-400">
                            Crítico: {{ $estadoData['summary']['critical'] }}
                        </span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-500/20 text-red-800 dark:text-red-400">
                            Emergencia: {{ $estadoData['summary']['emergency'] }}
                        </span>
                    </div>
                @endif
            </div>

            <x-form.button wire:click="consultarEstado" spinner="consultarEstado" primary label="Actualizar"
                class="shrink-0">
                <x-slot name="prepend">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </x-slot>
            </x-form.button>
        </div>

        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <x-form.select label="Filtrar por categoría" wire:model.live="selectedCategory">
                    <x-select.option label="Todas las categorías" value="all" />
                    <x-select.option label="🟢 OK (< 1 hora)" value="ok" />
                    <x-select.option label="🟡 Advertencia (1-24 horas)" value="warning" />
                    <x-select.option label="🟠 Crítico (1-7 días)" value="critical" />
                    <x-select.option label="🔴 Emergencia (> 7 días)" value="emergency" />
                    <x-select.option label="⚪ Nunca conectado" value="never_connected" />
                </x-form.select>
            </div>
            <div>
                <x-form.input label="Buscar por placa" wire:model.live.debounce.300ms="searchPlaca"
                    placeholder="Ingrese número de placa..." />
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="space-y-4" style="max-height: 60vh; overflow-y: auto;">
            @if ($loading)
                <div class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto text-indigo-500 animate-spin" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <p class="mt-4 text-slate-600 dark:text-slate-400">Consultando estado de dispositivos...</p>
                    </div>
                </div>
            @elseif ($creandoReporte && $dispositivoSeleccionado)
                <!-- Formulario para crear reporte -->
                <div
                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700/60 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300">
                            Crear Reporte - {{ $dispositivoSeleccionado['plate_number'] }}
                        </h3>
                        <x-form.button flat negative label="Cancelar" wire:click="cancelarReporte" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <x-form.datetime.picker label="Fecha Transmisión" wire:model="fecha_t" without-time />
                        <x-form.time.picker label="Hora Transmisión" wire:model="hora_t" format="24" />
                    </div>

                    <div class="mb-4">
                        <x-form.textarea label="Detalle del Reporte" wire:model="detalle" rows="6"
                            placeholder="Describa el problema de transmisión..." />
                    </div>

                    <div class="bg-slate-100 dark:bg-slate-700/50 p-3 rounded mb-4 text-xs">
                        <p class="font-semibold text-slate-700 dark:text-slate-300 mb-2">Información del Dispositivo:
                        </p>
                        <div class="grid grid-cols-2 gap-2 text-slate-600 dark:text-slate-400">
                            <div><span class="font-medium">Placa:</span> {{ $dispositivoSeleccionado['plate_number'] }}
                            </div>
                            <div><span class="font-medium">IMEI:</span> {{ $dispositivoSeleccionado['imei'] }}</div>
                            <div><span class="font-medium">SIM:</span> {{ $dispositivoSeleccionado['sim_number'] }}
                            </div>
                            <div><span class="font-medium">Última conexión:</span>
                                {{ $dispositivoSeleccionado['last_connection'] }}</div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-form.button primary label="Guardar Reporte" wire:click="guardarReporte"
                            spinner="guardarReporte" />
                    </div>
                </div>
            @elseif ($estadoData && count($this->getCategoriasFiltradas()) > 0)
                <!-- Tabla de dispositivos -->
                @foreach ($this->getCategoriasFiltradas() as $categoria)
                    @if (count($categoria['items']) > 0)
                        <div class="border border-slate-200 dark:border-slate-700/60 rounded-lg overflow-hidden"
                            x-data="{ open: true }">
                            <!-- Header de categoría -->
                            <div class="bg-slate-50 dark:bg-slate-800/50 px-4 py-3 border-b border-slate-200 dark:border-slate-700/60 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors"
                                @click="open = !open">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">{{ $this->getIconByCategory($categoria['key']) }}</span>
                                        <div>
                                            <h3 class="font-semibold text-slate-900 dark:text-slate-100">
                                                {{ $categoria['title'] }}</h3>
                                            <p class="text-xs text-slate-600 dark:text-slate-400">
                                                {{ $categoria['description'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $this->getBadgeColor($categoria['key']) }}">
                                            {{ $categoria['count'] }} dispositivos
                                        </span>
                                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400 transition-transform duration-200"
                                            :class="{ 'rotate-180': !open }" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de dispositivos -->
                            <div class="overflow-x-auto" x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/60">
                                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                                        <tr>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                Placa</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                Nombre</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                IMEI</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                SIM</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                Última Conexión</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                Tiempo Offline</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-medium text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                                Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700/60">
                                        @foreach ($categoria['items'] as $device)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <span
                                                        class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $device['plate_number'] }}</span>
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-300">
                                                    {{ $device['name'] }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400 font-mono">
                                                    {{ $device['imei'] }}</td>
                                                <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-400">
                                                    {{ $device['sim_number'] }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-slate-300">
                                                    {{ $device['last_connection'] }}
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    @if ($device['days_offline'] >= 1)
                                                        <span
                                                            class="text-sm font-medium text-red-600 dark:text-red-400">
                                                            {{ number_format($device['days_offline'], 1) }} días
                                                        </span>
                                                    @else
                                                        <span
                                                            class="text-sm font-medium text-amber-600 dark:text-amber-400">
                                                            {{ number_format($device['hours_offline'], 1) }} horas
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap">
                                                    <x-form.button xs primary label="Crear Reporte"
                                                        wire:click="prepararReporte({{ json_encode($device) }})" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endforeach
            @elseif ($estadoData)
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">No se encontraron dispositivos con los filtros
                        aplicados</p>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">Haga clic en "Actualizar" para consultar el
                        estado de los
                        dispositivos</p>
                </div>
            @endif
        </div>

        <x-slot name="footer">
            <div class="flex justify-between w-full">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                @if ($estadoData && !$creandoReporte)
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        Última actualización: {{ now()->format('d/m/Y H:i:s') }}
                    </div>
                @endif
            </div>
        </x-slot>

    </x-form.modal.card>
</div>
