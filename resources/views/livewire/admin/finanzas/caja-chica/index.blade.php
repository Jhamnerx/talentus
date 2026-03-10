<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <!-- Page header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Cajas Chicas ✨</h1>
        </div>

        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Search -->
            <form class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100"
                    type="search" placeholder="Buscar cajas" />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 dark:text-gray-500 ml-3 mr-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>


            <button wire:click='create'
                class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 cursor-pointer hover:dark:bg-gray-200">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                    <path
                        d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                </svg>
                <span class="ml-2">Nueva Caja</span>
            </button>

        </div>
    </div>

    <!-- Filters -->
    <div class="sm:flex sm:justify-between sm:items-center mb-5">
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <!-- Date filter -->
            <div class="relative" x-data="{ open: false, selected: 4 }">
                <button
                    class="btn justify-between min-w-44 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700/60 hover:border-gray-300"
                    @click.prevent="open = !open" :aria-expanded="open">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 fill-current text-gray-500 shrink-0 mr-2" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                        <span x-text="$refs.options.children[selected].children[1].innerHTML"></span>
                    </span>
                    <svg class="shrink-0 ml-1 fill-current text-gray-400" width="11" height="7"
                        viewBox="0 0 11 7">
                        <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z" />
                    </svg>
                </button>
                <div class="z-10 absolute top-full right-0 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded shadow-lg mt-1"
                    @click.outside="open = false" x-show="open" x-transition x-cloak>
                    <div class="text-sm text-gray-600 dark:text-gray-300" x-ref="options">
                        <button wire:click="filter(1)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3"
                            @click="selected = 0;open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 0 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Hoy</span>
                        </button>
                        <button wire:click="filter(7)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3"
                            @click="selected = 1;open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 1 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Últimos 7 días</span>
                        </button>
                        <button wire:click="filter(30)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3"
                            @click="selected = 2;open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 2 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Último Mes</span>
                        </button>
                        <button wire:click="filter(0)"
                            class="flex items-center w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 py-1 px-3"
                            @click="selected = 4;open = false">
                            <svg class="shrink-0 mr-2 fill-current text-indigo-500"
                                :class="selected !== 4 && 'invisible'" width="12" height="9" viewBox="0 0 12 9">
                                <path
                                    d="M10.28.28L3.989 6.575 1.695 4.28A1 1 0 00.28 5.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28.28z" />
                            </svg>
                            <span>Todos</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status filter -->
            <select wire:model.live="estado_filter"
                class="form-select dark:bg-gray-800 dark:border-gray-700/60 dark:text-gray-100">
                <option value="">Todos los estados</option>
                <option value="1">Abiertas</option>
                <option value="0">Cerradas</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700/60"
        style="height: calc(100vh - 280px); min-height: 500px;">
        <div class="overflow-x-auto overflow-y-auto h-full">
            <table class="table-auto w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead
                    class="text-xs uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/20 border-t border-gray-200 dark:border-gray-700/60 sticky top-0 z-10">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre / Ref</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Saldo Inicial</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Saldo Actual</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Docs</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">F. Apertura</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">F. Cierre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Usuario</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($cajas as $caja)
                        <tr>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800 dark:text-gray-100">{{ $caja->nombre }}</div>
                                @if ($caja->descripcion)
                                    <div class="text-xs text-gray-500">{{ $caja->descripcion }}</div>
                                @endif
                                @if ($caja->reference_number)
                                    <div class="text-xs text-blue-600 dark:text-blue-400 font-mono">
                                        Ref: {{ $caja->reference_number }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">
                                        S/ {{ number_format($caja->saldo_inicial, 2) }}
                                    </div>
                                    @if ($caja->saldo_inicial_usd > 0)
                                        <div class="text-xs text-gray-600 dark:text-gray-400">
                                            $ {{ number_format($caja->saldo_inicial_usd, 2) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">
                                    <div class="font-semibold text-emerald-600 dark:text-emerald-400">
                                        S/ {{ number_format($caja->saldo_actual, 2) }}
                                    </div>
                                    @if ($caja->saldo_actual_usd > 0)
                                        <div class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                            $ {{ number_format($caja->saldo_actual_usd, 2) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $caja->movimientos_count }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                {{ $caja->fecha_apertura->format('d/m/Y') }}
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                {{ $caja->fecha_cierre ? $caja->fecha_cierre->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                @if ($caja->estado)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        Abierta
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Cerrada
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                {{ $caja->user->name }}
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Botón PDF A4 --}}
                                    <a href="{{ route('finanzas.caja-chica.reporte-a4', $caja->id) }}"
                                        target="_blank"
                                        class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                        title="Reporte PDF A4">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="ml-1">PDF</span>
                                    </a>

                                    {{-- Botón Excel --}}
                                    <a href="{{ route('finanzas.caja-chica.reporte-excel', $caja->id) }}"
                                        class="btn btn-sm bg-emerald-500 hover:bg-emerald-600 text-white"
                                        title="Reporte Excel">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path
                                                d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span class="ml-1">Excel</span>
                                    </a>
                                </div>

                                {{-- Botones de Acción según Estado --}}

                                @if ($caja->estado)
                                    <x-form.button xs primary icon="pencil" wire:click="edit({{ $caja->id }})"
                                        title="Editar caja" />

                                    <x-form.button xs warning wire:click="closeCash({{ $caja->id }})"
                                        title="Cerrar caja">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-form.button>
                                @endif


                                <x-form.button xs negative icon="trash"
                                    wire:click="confirmDelete({{ $caja->id }})" title="Eliminar caja" />

        </div>
        </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="px-2 first:pl-5 last:pr-5 py-8 text-center text-gray-500">
                No se encontraron cajas chicas
            </td>
        </tr>
        @endforelse
        </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-5">
    {{ $cajas->links() }}
</div>

@livewire('admin.finanzas.caja-chica.save')
</div>
