<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto" x-data="{ anchorClienteId: null, anchorDivisa: null }"
    x-effect="if ($wire.selected.length === 0) { anchorClienteId = null; anchorDivisa = null; }">

    <div class="mb-8">
        <!-- Título y botón limpiar filtros -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cobros Recurrentes 💰</h1>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                @if ($estado !== null || $filtroFecha || $filtroVencimiento || $clienteId || $search)
                    <button wire:click="clearFilters" class="btn bg-red-500 hover:bg-red-600 text-white">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M5.414 4L4 5.414 6.586 8 4 10.586 5.414 12 8 9.414 10.586 12 12 10.586 9.414 8 12 5.414 10.586 4 8 6.586z" />
                        </svg>
                        <span class="ml-2">Limpiar</span>
                    </button>
                @endif
                <button wire:click="exportar" wire:loading.attr="disabled"
                    class="btn bg-emerald-500 hover:bg-emerald-600 text-white">
                    <span wire:loading.remove wire:target="exportar" class="flex items-center gap-1">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path d="M8 0L3 5h3v7h4V5h3L8 0zm-3 14v2h6v-2H5z" />
                        </svg>
                        <span class="hidden xs:block">Exportar</span>
                    </span>
                    <span wire:loading wire:target="exportar" class="flex items-center gap-1">
                        <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                        </svg>
                        <span class="hidden xs:block">Generando...</span>
                    </span>
                </button>
                @can('admin.cobros.create')
                    <button wire:click="$dispatch('abrirRegistrarFlota')"
                        class="btn bg-indigo-500 text-white hover:bg-indigo-600 dark:bg-indigo-600 dark:hover:bg-indigo-500">
                        <svg class="w-4 h-4 fill-current opacity-70 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M13 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM2 10a4 4 0 0 1 4-4h1.5a5 5 0 0 0-.5 2 5 5 0 0 0 1.294 3.35A4.002 4.002 0 0 1 2 10Zm5 4a3 3 0 1 1 6 0H7Z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar flota</span>
                    </button>
                    <button wire:click="$dispatch('abrirRegistrarCobro')"
                        class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar</span>
                    </button>
                @endcan
            </div>
        </div>

        <!-- Filtros: una sola fila de 5 columnas -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

            <!-- 1. Estado del Cobro -->
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                    aria-label="Select state" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                    <span class="flex items-center">
                        <span class="text-xs font-semibold mr-1">Estado:</span>
                        <span class="text-xs font-medium">
                            @if ($estado === 'ACTIVO')
                                ✅ Activo
                            @elseif ($estado === 'SUSPENDIDO')
                                ⏸️ Suspendido
                            @elseif ($estado === 'CANCELADO')
                                ❌ Cancelado
                            @else
                                Todos
                            @endif
                        </span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                        height="7" viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="origin-top-right z-10 absolute left-0 min-w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                        Estado del Cobro</div>
                    <div class="mb-1">
                        <button wire:click='$set("estado","ACTIVO")'
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $estado === 'ACTIVO' ? 'true' : 'false' }} && 'invisible'" width="12"
                                height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">✅ Activo</span>
                        </button>
                        <button wire:click='$set("estado","SUSPENDIDO")'
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $estado === 'SUSPENDIDO' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">⏸️ Suspendido</span>
                        </button>
                        <button wire:click='$set("estado","CANCELADO")'
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $estado === 'CANCELADO' ? 'true' : 'false' }} && 'invisible'" width="12"
                                height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">❌ Cancelado</span>
                        </button>
                        <button wire:click='$set("estado",null)'
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $estado === null ? 'true' : 'false' }} && 'invisible'" width="12"
                                height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">Todos</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 4. Filtro Registros (cuándo se creó) -->
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                    aria-label="Filtrar registros" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <span class="text-xs font-semibold mr-1">📝:</span>
                        <span class="text-xs font-medium truncate">
                            @if ($filtroFecha === 'registrados_7dias')
                                7d
                            @elseif ($filtroFecha === 'registrados_mes')
                                Mes
                            @else
                                Todos
                            @endif
                        </span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                        height="7" viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="origin-top-right z-10 absolute left-0 min-w-56 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                        📝 Registros (Fecha Creación)
                    </div>
                    <div class="mb-1">
                        <button wire:click="setFiltroFecha('registrados_7dias')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $filtroFecha === 'registrados_7dias' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">Últimos 7 días</span>
                        </button>
                        <button wire:click="setFiltroFecha('registrados_mes')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $filtroFecha === 'registrados_mes' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">Este mes</span>
                        </button>
                        <button wire:click="setFiltroFecha(null)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $filtroFecha === null ? 'true' : 'false' }} && 'invisible'" width="12"
                                height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">Todos</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. Filtro Vencimientos -->
            <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                <button
                    class="btn bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 w-full justify-between"
                    aria-label="Filtrar vencimientos" aria-haspopup="true" @click.prevent="open = !open"
                    :aria-expanded="open">
                    <span class="flex items-center">
                        <span class="text-xs font-semibold mr-1">⏰:</span>
                        <span class="text-xs font-medium truncate">
                            @if ($filtroVencimiento === 'vencidos')
                                ❌ Venc
                            @elseif ($filtroVencimiento === 'vencen_7dias')
                                🟡 7d
                            @elseif ($filtroVencimiento === 'vencen_fin_mes')
                                🔵 Fin
                            @elseif ($filtroVencimiento === 'vencen_proximo_mes')
                                🟣 Mes
                            @else
                                Todos
                            @endif
                        </span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500" width="11"
                        height="7" viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="origin-top-right z-10 absolute left-0 min-w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 pt-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" x-cloak style="display: none;">
                    <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-1.5 pb-2 px-3">
                        ⏰ Vencimiento (Próxima Facturación)
                    </div>
                    <div class="mb-1">
                        <button wire:click="setFiltroVencimiento('vencidos')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-red-500"
                                :class="!{{ $filtroVencimiento === 'vencidos' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">🔴 Vencidos (ya pasaron)</span>
                        </button>
                        <button wire:click="setFiltroVencimiento('vencen_7dias')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-amber-500"
                                :class="!{{ $filtroVencimiento === 'vencen_7dias' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">🟡 Vencen en 7 días</span>
                        </button>
                        <button wire:click="setFiltroVencimiento('vencen_fin_mes')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-blue-500"
                                :class="!{{ $filtroVencimiento === 'vencen_fin_mes' ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">🔵 Vencen a fin de mes</span>
                        </button>
                        <button wire:click="setFiltroVencimiento('vencen_proximo_mes')"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="!{{ $filtroVencimiento === 'vencen_proximo_mes' ? 'true' : 'false' }} &&
                                    'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">🟣 Vencen en próximo mes</span>
                        </button>
                        <button wire:click="setFiltroVencimiento(null)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1.5 px-3 cursor-pointer"
                            @click="open = false">
                            <svg class="shrink-0 mr-2 fill-current text-gray-400"
                                :class="!{{ $filtroVencimiento === null ? 'true' : 'false' }} && 'invisible'"
                                width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span class="text-sm">Todos</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- 4. Cliente -->
            <div>
                <x-form.select label="Cliente" wire:model.live="clienteId" placeholder="Seleccionar cliente..."
                    :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id" :clearable="true"
                    option-description="numero_documento" />
            </div>

            <!-- 5. Búsqueda general -->
            <div>
                <label for="action-search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Búsqueda general
                </label>
                <div class="relative">
                    <input wire:model.live.debounce='search' id="action-search"
                        class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100 w-full"
                        type="search" placeholder="Placa, contacto, periodo..." />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 group-hover:text-slate-500 dark:group-hover:text-gray-400 ml-3 mr-2"
                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        {{-- Barra de acciones para seleccionados --}}
        <div x-show="$wire.selected.length > 0" x-cloak style="display:none;"
            class="flex items-center justify-between gap-3 mt-4 px-4 py-3 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 rounded-xl">
            <div class="flex items-center gap-2 text-sm text-indigo-800 dark:text-indigo-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-semibold" x-text="$wire.selected.length + ' vehículo(s) seleccionado(s)'"></span>
                <span x-show="anchorDivisa !== null" class="text-xs font-normal text-indigo-500 dark:text-indigo-300">
                    · mismo cliente · <span class="font-semibold" x-text="anchorDivisa"></span>
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button wire:click="clearSelected"
                    class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">
                    Quitar selección
                </button>
                <button wire:click="renovarSeleccionados" wire:loading.attr="disabled"
                    class="btn bg-amber-500 hover:bg-amber-600 text-white text-sm py-1.5 px-4">
                    <span wire:loading.remove wire:target="renovarSeleccionados" class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Renovar
                    </span>
                    <span wire:loading wire:target="renovarSeleccionados">Procesando...</span>
                </button>
                <button wire:click="cobrarSeleccionados" wire:loading.attr="disabled"
                    class="btn bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-1.5 px-4">
                    <span wire:loading.remove wire:target="cobrarSeleccionados" class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cobrar seleccionados
                    </span>
                    <span wire:loading wire:target="cobrarSeleccionados">Procesando...</span>
                </button>
            </div>
        </div>

        <!-- Per Page Selector con WireUI -->
        <div class="flex items-center gap-3 mt-5">
            <label for="perPage" class="text-sm text-gray-600 dark:text-gray-300">Mostrar:</label>
            <div class="w-24">
                <x-form.native.select wire:model.live="perPage" id="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </x-form.native.select>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-300">registros</span>
        </div>

        <!-- Tabla de Detalles Agrupados por Empresa -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl mt-5">
            <header class="px-5 py-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Vehículos por cobrar
                    <span class="text-gray-400 dark:text-gray-500 font-medium">{{ $cobros->total() }}</span>
                </h2>
            </header>
            <div>
                <div class="overflow-x-auto min-h-screen">
                    <table class="table-auto w-full dark:text-gray-300">
                        <thead
                            class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-b border-gray-100 dark:border-gray-700/60">
                            <tr>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="font-semibold text-center">#</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Vehículo</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Plan</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Vigencia</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Días rest.</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="font-semibold text-left">Estado</div>
                                </th>
                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-sm">
                            @php
                                $currentCliente = null;
                            @endphp

                            @foreach ($cobros as $cobro)
                                @php
                                    $clienteModel = $cobro->clientes;
                                    $clienteNombre = $clienteModel?->razon_social ?? 'Sin cliente';
                                    $clienteContacto = $clienteModel?->contactos?->first()?->nombre ?? '';
                                    $showClienteHeader = $currentCliente !== $clienteNombre;
                                    $currentCliente = $clienteNombre;

                                    $tipoComprobante = $cobro->tipo_pago ?? 'FACTURA';
                                    $divisaLabel = $cobro->divisa === 'USD' ? 'USD' : 'S/.';

                                    $planNombre = $cobro->plan_nombre;
                                    $diasRestantes = $cobro->dias_restantes;
                                    $fechaInicioStr = $cobro->fecha_inicio?->format('d/m/Y') ?? '—';
                                    $fechaVencStr = $cobro->fecha_vencimiento?->format('d/m/Y') ?? '—';
                                    $esActivo = $cobro->es_activo;

                                    // Texto descriptivo para días restantes
                                    if ($diasRestantes === null) {
                                        $diasTexto = '—';
                                    } elseif ($diasRestantes < 0) {
                                        $diasTexto =
                                            abs($diasRestantes) .
                                            ' día' .
                                            (abs($diasRestantes) != 1 ? 's' : '') .
                                            ' atrasado';
                                    } elseif ($diasRestantes == 0) {
                                        $diasTexto = 'Hoy';
                                    } elseif ($diasRestantes == 1) {
                                        $diasTexto = 'Mañana';
                                    } else {
                                        $diasTexto = $diasRestantes . ' días';
                                    }

                                    // Colores y estado según días restantes
                                    if (!$esActivo) {
                                        $bgColor = 'bg-gray-50 dark:bg-gray-900/20';
                                        $textColor = 'text-gray-400 dark:text-gray-500';
                                        $estadoTexto = $cobro->estado?->value ?? 'INACTIVO';
                                    } elseif ($diasRestantes === null || $diasRestantes < 0) {
                                        $bgColor = 'bg-red-50 dark:bg-red-900/10';
                                        $textColor = 'text-red-700 dark:text-red-400';
                                        $estadoTexto = $diasRestantes === null ? 'SIN FECHA' : 'VENCIDO';
                                    } elseif ($diasRestantes <= 7) {
                                        $bgColor = 'bg-orange-50 dark:bg-orange-900/10';
                                        $textColor = 'text-orange-700 dark:text-orange-400';
                                        $estadoTexto = 'POR VENCER';
                                    } elseif ($diasRestantes <= 15) {
                                        $bgColor = 'bg-yellow-50 dark:bg-yellow-900/10';
                                        $textColor = 'text-yellow-700 dark:text-yellow-400';
                                        $estadoTexto = 'PRÓXIMO';
                                    } else {
                                        $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                        $textColor = 'text-green-700 dark:text-green-400';
                                        $estadoTexto = 'VIGENTE';
                                    }
                                @endphp

                                @if ($showClienteHeader)
                                    <tr
                                        class="bg-indigo-100 dark:bg-indigo-900/40 border-t-2 border-indigo-200 dark:border-indigo-700">
                                        <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-2">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-bold text-sm text-indigo-900 dark:text-indigo-100">
                                                    {{ $clienteNombre }}
                                                </span>
                                                @if ($clienteContacto)
                                                    <span class="text-xs text-indigo-700 dark:text-indigo-300">
                                                        • {{ $clienteContacto }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                <tr class="border-b border-gray-200 dark:border-gray-700/60 hover:bg-gray-100 dark:hover:bg-gray-700/30 {{ $bgColor }}"
                                    wire:key='cobro-{{ $cobro->id }}'>

                                    <!-- Checkbox selección -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 w-px">
                                        @php $cbDivisa = $cobro->periodos->first()?->divisa ?? 'PEN'; @endphp
                                        <input type="checkbox"
                                            :checked="$wire.selected.some(id => id == {{ $cobro->id }})"
                                            :disabled="anchorClienteId !== null && (anchorClienteId !=
                                                '{{ $cobro->clientes_id }}' ||
                                                anchorDivisa !== '{{ $cbDivisa }}')"
                                            @change="
                                                const checked = $event.target.checked;
                                                const cobroId = {{ $cobro->id }};
                                                const clienteId = '{{ $cobro->clientes_id }}';
                                                const divisa = '{{ $cbDivisa }}';
                                                if (checked) {
                                                    if (anchorClienteId === null) {
                                                        anchorClienteId = clienteId;
                                                        anchorDivisa = divisa;
                                                    }
                                                    $wire.set('selected', [...$wire.selected, cobroId]);
                                                } else {
                                                    const newSelected = $wire.selected.filter(id => id != cobroId);
                                                    $wire.set('selected', newSelected);
                                                    if (newSelected.length === 0) {
                                                        anchorClienteId = null;
                                                        anchorDivisa = null;
                                                    }
                                                }
                                            "
                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 disabled:opacity-30 disabled:cursor-not-allowed" />
                                    </td>

                                    <!-- Vehículo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3">
                                        @if ($cobro->vehiculo)
                                            <div class="font-bold {{ $textColor }}">
                                                {{ $cobro->vehiculo->placa }}
                                            </div>
                                            @if ($cobro->vehiculo->marca || $cobro->vehiculo->modelo)
                                                <div class="text-xs text-gray-600 dark:text-gray-400">
                                                    {{ $cobro->vehiculo->marca }} {{ $cobro->vehiculo->modelo }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">Sin vehículo</span>
                                        @endif
                                    </td>

                                    <!-- Plan -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <div
                                            class="flex items-center gap-1.5 font-medium text-gray-900 dark:text-gray-100">
                                            {{ $divisaLabel }}
                                            {{ number_format($cobro->monto ?? 0, 2) }}
                                            @if ($tipoComprobante === 'FACTURA')
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-blue-500 dark:text-blue-400 shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8" title="Factura — incluye IGV 18%">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-gray-400 dark:text-gray-500 shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.8" title="Recibo — precio sin IGV">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $planNombre }}
                                        </div>
                                    </td>

                                    <!-- Período activo -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($cobro->fecha_inicio && $cobro->fecha_vencimiento)
                                            <div class="text-xs font-medium text-gray-700 dark:text-gray-200">
                                                {{ $fechaInicioStr }} — {{ $fechaVencStr }}
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                                {{ $cobro->periodo ?? '—' }}
                                            </div>
                                        @else
                                            <span class="text-xs text-amber-600 dark:text-amber-400">Sin período</span>
                                        @endif
                                    </td>

                                    <!-- Días Restantes -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        @if ($esActivo && $diasRestantes >= 0)
                                            <div class="font-bold {{ $textColor }} text-xs">
                                                {{ $diasTexto }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                                        @endif
                                    </td>

                                    <!-- Estado Badge -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold {{ $textColor }} bg-white dark:bg-gray-900/50 border-2 border-current rounded">
                                            {{ $estadoTexto }}
                                        </span>
                                    </td>

                                    <!-- Acciones -->
                                    <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                        <div class="flex items-center gap-2">
                                            <button
                                                wire:click="$dispatch('abrirRegistrarCobro', { cobroId: {{ $cobro->id }} })"
                                                class="text-gray-400 hover:text-blue-500 transition"
                                                title="Editar suscripción">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            <div class="form-switch" x-data="{ checked: {{ $esActivo ? 'true' : 'false' }} }">
                                                <input wire:click="cambiarEstado({{ $cobro->id }})"
                                                    type="checkbox" id="switch{{ $cobro->id }}" class="sr-only"
                                                    x-model="checked" />
                                                <label class="bg-gray-400 dark:bg-gray-700"
                                                    for="switch{{ $cobro->id }}">
                                                    <span class="bg-white dark:bg-gray-300 shadow-sm"
                                                        aria-hidden="true"></span>
                                                    <span class="sr-only">Estado</span>
                                                </label>
                                            </div>

                                            {{-- Botón renovar período --}}
                                            <button
                                                wire:click="$dispatch('abrirRenovar', { cobroId: {{ $cobro->id }} })"
                                                class="text-gray-400 hover:text-indigo-500 transition"
                                                title="Renovar período">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                            {{-- Abrir modal períodos --}}
                                            @php $cntPeriodos = $cobro->periodos->count(); @endphp
                                            <button
                                                wire:click="$dispatch('abrirVerPeriodos', { cobroId: {{ $cobro->id }} })"
                                                class="relative text-gray-400 hover:text-indigo-500 transition"
                                                title="Historial de períodos ({{ $cntPeriodos }})">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                @if ($cntPeriodos > 0)
                                                    <span
                                                        class="absolute -top-1.5 -right-1.5 inline-flex items-center justify-center w-3.5 h-3.5 rounded-full bg-indigo-500 text-white text-3xs font-bold leading-none">
                                                        {{ $cntPeriodos > 9 ? '9+' : $cntPeriodos }}
                                                    </span>
                                                @endif
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($cobros->count() < 1)
                                <tr>
                                    <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-8 text-center">
                                        <div class="text-gray-500 dark:text-gray-400">No hay registros</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $cobros->links() }}
        </div>

    </div>

    {{-- Modal de renovación de período (individual) --}}
    @livewire('admin.cobros.renovar')

    {{-- Modal de renovación masiva --}}
    @livewire('admin.cobros.renovar-multiple')

    {{-- Modal registrar / editar suscripción --}}
    @livewire('admin.cobros.registrar-cobro')

    {{-- Modal registrar flota (múltiples vehículos) --}}
    @livewire('admin.cobros.registrar-flota')

    {{-- Modal historial de períodos --}}
    @livewire('admin.cobros.ver-periodos')

</div>
