<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 dark:text-slate-100 font-bold">Mantenimientos</h1>
        </div>
        <div class="flex items-center gap-2">
            <form class="relative" @submit.prevent>
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live='search' id="action-search"
                    class="form-input pl-9 focus:border-slate-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200 dark:placeholder-gray-500"
                    type="search" placeholder="Buscar placa, número, detalle..." />
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </form>

            @can('exportar-mantenimientos-vehiculos')
                <button wire:click.prevent='openModalExport' type="button"
                    class="btn bg-emerald-600 hover:bg-emerald-700 text-white">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 32 32">
                        <path
                            d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Exportar</span>
                </button>
            @endcan

            @can('crear-mantenimientos-vehiculos')
                <button wire:click.prevent="openModalSave()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                    <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span class="hidden xs:block ml-2">Nuevo</span>
                </button>
            @endcan
        </div>
    </div>

    {{-- Status filter tabs --}}
    <div class="flex gap-1 mb-4 border-b border-slate-200 dark:border-gray-700">
        @php
            $tabs = [
                '' => ['label' => 'Todos', 'count' => $counts['todos'], 'color' => 'indigo'],
                'PENDIENTE' => ['label' => 'Pendiente', 'count' => $counts['PENDIENTE'], 'color' => 'orange'],
                'COMPLETADA' => ['label' => 'Completada', 'count' => $counts['COMPLETADA'], 'color' => 'emerald'],
                'CANCELADO' => ['label' => 'Cancelado', 'count' => $counts['CANCELADO'], 'color' => 'rose'],
            ];
        @endphp
        @foreach ($tabs as $key => $tab)
            <button wire:click="setStatusFilter('{{ $key }}')"
                class="px-4 py-2 text-sm font-medium border-b-2 transition-colors cursor-pointer
                    {{ $statusFilter === $key
                        ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400'
                        : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-200' }}">
                {{ $tab['label'] }}
                <span
                    class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full
                    {{ $statusFilter === $key
                        ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300'
                        : 'bg-slate-100 text-slate-500 dark:bg-gray-700 dark:text-gray-400' }}">
                    {{ $tab['count'] }}
                </span>
            </button>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-sm border border-slate-200 dark:border-gray-700 mb-8">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 dark:text-gray-400 bg-slate-50 dark:bg-gray-700/50 border-b border-slate-200 dark:border-gray-600">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Número</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Vehículo / Cliente</th>
                        <th class="px-4 py-3 text-left">Detalle</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Fecha Programada</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Estado</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Orden de Trabajo</th>
                        <th class="px-4 py-3 whitespace-nowrap text-left">Informe</th>
                        @canany(['editar-mantenimientos-vehiculos', 'eliminar-mantenimientos-vehiculos',
                            'task-mantenimientos-vehiculos', 'mark-mantenimientos-vehiculos'])
                            <th class="px-4 py-3 whitespace-nowrap text-left">Acciones</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-200 dark:divide-gray-700">
                    @forelse ($mantenimientos as $mantenimiento)
                        @php
                            $fecha = $mantenimiento->fecha_hora_mantenimiento;
                            $hoy = now()->startOfDay();
                            $diff = $hoy->diffInDays($fecha, false);
                            $urgencia = null;
                            if ($diff < 0) {
                                $urgencia = [
                                    'label' => 'VENCIDO',
                                    'class' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
                                ];
                            } elseif ($diff === 0) {
                                $urgencia = [
                                    'label' => 'HOY',
                                    'class' =>
                                        'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400',
                                ];
                            } elseif ($diff <= 7) {
                                $urgencia = [
                                    'label' => 'PRÓXIMO',
                                    'class' =>
                                        'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                                ];
                            }
                        @endphp
                        <tr wire:key='mant-{{ $mantenimiento->id }}'
                            class="hover:bg-slate-50 dark:hover:bg-gray-700/30">
                            {{-- Número --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $mantenimiento->numero }}</div>
                                <div class="text-xs text-slate-400 dark:text-gray-500">
                                    {{ $mantenimiento->created_at->format('d/m/Y') }}</div>
                            </td>

                            {{-- Vehículo / Cliente --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-slate-800 dark:text-gray-100">
                                    {{ $mantenimiento->vehiculo->placa }}</div>
                                <div class="text-xs text-slate-500 dark:text-gray-400">
                                    {{ $mantenimiento->vehiculo->cliente?->razon_social ?? 'Sin cliente' }}
                                </div>
                            </td>

                            {{-- Detalle --}}
                            <td class="px-4 py-3 max-w-xs">
                                <div class="text-slate-700 dark:text-gray-300 truncate"
                                    title="{{ $mantenimiento->detalle_trabajo }}">
                                    {{ $mantenimiento->detalle_trabajo ?? '—' }}
                                </div>
                                @if ($mantenimiento->nota)
                                    <div class="text-xs text-slate-400 dark:text-gray-500 truncate"
                                        title="{{ $mantenimiento->nota }}">
                                        {{ $mantenimiento->nota }}
                                    </div>
                                @endif
                            </td>

                            {{-- Fecha programada + urgencia --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-700 dark:text-gray-300">
                                    {{ $fecha->format('d/m/Y') }}
                                </div>
                                @if ($urgencia && $mantenimiento->estado->name === 'PENDIENTE')
                                    <span
                                        class="inline-flex text-xs font-semibold px-1.5 py-0.5 rounded {{ $urgencia['class'] }}">
                                        {{ $urgencia['label'] }}
                                    </span>
                                @endif
                            </td>

                            {{-- Estado --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex font-medium rounded-full text-center px-2.5 py-0.5
                                    bg-{{ $mantenimiento->estado->color() }}-100 text-{{ $mantenimiento->estado->color() }}-600
                                    dark:bg-{{ $mantenimiento->estado->color() }}-900/40 dark:text-{{ $mantenimiento->estado->color() }}-400">
                                    {{ $mantenimiento->estado->name }}
                                </span>
                            </td>

                            {{-- OT vinculada --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($mantenimiento->workOrderActivo)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        OT #{{ str_pad($mantenimiento->workOrderActivo->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                @else
                                    @can('crear-ordenes-trabajo')
                                        <button wire:click="createWorkOrder({{ $mantenimiento->id }})"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium text-slate-500 hover:text-blue-600 hover:bg-blue-50 dark:text-gray-400 dark:hover:text-blue-400 dark:hover:bg-blue-900/20 transition-colors cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Crear OT
                                        </button>
                                    @endcan
                                @endif
                            </td>

                            {{-- Informe PDF --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a target="_blank" href="{{ route('admin.pdf.mantenimiento', $mantenimiento) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                    title="Descargar PDF">
                                    <svg class="w-7 shrink-0" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072"
                                            style="fill:#909090" />
                                        <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2" style="fill:#f4f4f4" />
                                        <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655" style="fill:#7a7b7c" />
                                        <path d="M22.472,10.211H2.395V3.379H22.472v6.832" style="fill:#dd2025" />
                                        <path
                                            d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                                            style="fill:#464648" />
                                        <path
                                            d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                                            style="fill:#464648" />
                                        <path d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538"
                                            style="fill:#464648" />
                                        <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z" style="fill:#909090" />
                                        <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
                                    </svg>
                                </a>
                            </td>

                            {{-- Acciones --}}
                            @canany(['editar-mantenimientos-vehiculos', 'eliminar-mantenimientos-vehiculos',
                                'task-mantenimientos-vehiculos', 'mark-mantenimientos-vehiculos'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div x-data="{ open: false }" class="relative inline-flex">
                                        <button @click.prevent="open = !open"
                                            :class="{ 'bg-slate-100 dark:bg-gray-700': open }"
                                            class="text-slate-400 hover:text-slate-500 dark:text-gray-500 dark:hover:text-gray-300 rounded-full cursor-pointer"
                                            aria-haspopup="true" :aria-expanded="open">
                                            <span class="sr-only">Acciones</span>
                                            <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                                <circle cx="16" cy="16" r="2" />
                                                <circle cx="10" cy="16" r="2" />
                                                <circle cx="22" cy="16" r="2" />
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false"
                                            @keydown.escape.window="open = false"
                                            x-transition:enter="transition ease-out duration-200 transform"
                                            x-transition:enter-start="opacity-0 -translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="origin-top-right z-10 absolute right-0 top-full min-w-44 bg-white dark:bg-gray-800 border border-slate-200 dark:border-gray-700 py-1.5 rounded shadow-lg mt-1 divide-y divide-gray-100 dark:divide-gray-700 focus:outline-none"
                                            x-cloak>
                                            <ul>
                                                @can('editar-mantenimientos-vehiculos')
                                                    <li>
                                                        <a href="javascript:void(0)" @click="open = false"
                                                            wire:click.prevent='openModalEdit({{ $mantenimiento->id }})'
                                                            class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                            Editar
                                                        </a>
                                                    </li>
                                                @endcan

                                                @can('crear-ordenes-trabajo')
                                                    <li>
                                                        <a href="javascript:void(0)" @click="open = false"
                                                            wire:click.prevent="createWorkOrder({{ $mantenimiento->id }})"
                                                            class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                            </svg>
                                                            Crear OT
                                                        </a>
                                                    </li>
                                                @endcan

                                                {{-- @can('task-mantenimientos-vehiculos')
                                                    <li>
                                                        <a href="javascript:void(0)" @click="open = false"
                                                            wire:click.prevent="createTask({{ $mantenimiento->id }})"
                                                            class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-yellow-500"
                                                                viewBox="0 0 64 64" fill="none" stroke="currentColor">
                                                                <g stroke-linecap="round" stroke-width="3"
                                                                    stroke-linejoin="round">
                                                                    <path
                                                                        d="M47.75,37.458,56.352,45a8.034,8.034,0,0,1,.575,11.347c-.091.1-.184.2-.28.3h0a8.035,8.035,0,0,1-11.363,0c-.1-.1-.189-.2-.28-.3L35.667,46.167" />
                                                                    <polyline data-cap="butt"
                                                                        points="29.439 25.439 20 16 20 12 13 5 5 13 12 20 16 20 25.234 29.234" />
                                                                    <path
                                                                        d="M58.376,14.5,51,21.879l-8.872-8.872L49.5,5.629a15.142,15.142,0,0,0-5.266-.586,13.9,13.9,0,0,0-12.7,12.7,15.124,15.124,0,0,0,.588,5.271L6.283,46.344a3.89,3.89,0,0,0-.277,5.495c.044.049.089.1.135.142l5.882,5.882a3.891,3.891,0,0,0,5.5-.009c.044-.045.088-.09.13-.137L41,31.881a15.127,15.127,0,0,0,5.272.588,13.9,13.9,0,0,0,12.7-12.7A15.145,15.145,0,0,0,58.376,14.5Z" />
                                                                </g>
                                                            </svg>
                                                            Crear Tarea Técnico
                                                        </a>
                                                    </li>
                                                @endcan --}}

                                                @can('mark-mantenimientos-vehiculos')
                                                    @if ($mantenimiento->estado->name === 'COMPLETADA')
                                                        <li>
                                                            <a href="javascript:void(0)" @click="open = false"
                                                                wire:click.prevent="markAs({{ $mantenimiento->id }}, 'CANCELADO')"
                                                                class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-rose-500"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Marcar Cancelado
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="javascript:void(0)" @click="open = false"
                                                                wire:click.prevent="markAs({{ $mantenimiento->id }}, 'COMPLETADA')"
                                                                class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-emerald-500"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Marcar Completado
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endcan

                                                @can('eliminar-mantenimientos-vehiculos')
                                                    <li>
                                                        <a href="javascript:void(0)" @click="open = false"
                                                            wire:click.prevent='openModalDelete({{ $mantenimiento->id }})'
                                                            class="group flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Eliminar
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-slate-500 dark:text-gray-400">
                                No hay mantenimientos registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $mantenimientos->links() }}
    </div>


</div>
