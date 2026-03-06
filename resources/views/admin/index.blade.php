<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full |" :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ page: 'dashboard-inicio', sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">

        <div class="relative bg-indigo-200 p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

            <!-- Background illustration -->
            <div class="absolute right-0 top-0 -mt-4 mr-16 pointer-events-none hidden xl:block" aria-hidden="true">
                <svg width="319" height="198" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path id="welcome-a" d="M64 0l64 128-64-20-64 20z" />
                        <path id="welcome-e" d="M40 0l40 80-40-12.5L0 80z" />
                        <path id="welcome-g" d="M40 0l40 80-40-12.5L0 80z" />
                        <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="welcome-b">
                            <stop stop-color="#A5B4FC" offset="0%" />
                            <stop stop-color="#818CF8" offset="100%" />
                        </linearGradient>
                        <linearGradient x1="50%" y1="24.537%" x2="50%" y2="100%" id="welcome-c">
                            <stop stop-color="#4338CA" offset="0%" />
                            <stop stop-color="#6366F1" stop-opacity="0" offset="100%" />
                        </linearGradient>
                    </defs>
                    <g fill="none" fill-rule="evenodd">
                        <g transform="rotate(64 36.592 105.604)">
                            <mask id="welcome-d" fill="#fff">
                                <use xlink:href="#welcome-a" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-a" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-d)" d="M64-24h80v152H64z" />
                        </g>
                        <g transform="rotate(-51 91.324 -105.372)">
                            <mask id="welcome-f" fill="#fff">
                                <use xlink:href="#welcome-e" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-e" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-f)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                        <g transform="rotate(44 61.546 392.623)">
                            <mask id="welcome-h" fill="#fff">
                                <use xlink:href="#welcome-g" />
                            </mask>
                            <use fill="url(#welcome-b)" xlink:href="#welcome-g" />
                            <path fill="url(#welcome-c)" mask="url(#welcome-h)" d="M40.333-15.147h50v95h-50z" />
                        </g>
                    </g>
                </svg>
            </div>

            <!-- Content -->
            <div class="relative">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">Bienvenido al Panel de Talentus. 👋
                </h1>
                <p>Aqui veras el resumen de todo el sistema:</p>

            </div>

        </div>

        <div class="mt-8">

            @php
                $fechaInicio = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
                $fechaFin = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            @endphp

            {{-- ── Selector de fechas sticky (abarca los 3 componentes) ────── --}}
            <div wire:ignore
                class="sticky top-16 z-20 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 mb-6"
                x-data="dashboardDatepicker('{{ $fechaInicio }}', '{{ $fechaFin }}')" x-init="init()">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="relative">
                        <input x-ref="input"
                            class="form-input pl-9 dark:bg-slate-700 text-slate-600 dark:text-slate-200 font-medium w-62"
                            placeholder="Seleccionar rango" readonly />
                        <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                            <svg class="fill-current text-gray-400 dark:text-gray-500 ml-3" width="16"
                                height="16" viewBox="0 0 16 16">
                                <path d="M5 4a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H5Z" />
                                <path
                                    d="M4 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4H4ZM2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <button @click="setPreset('hoy')"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Hoy</button>
                        <button @click="setPreset('semana')"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Esta
                            semana</button>
                        <button @click="setPreset('mes')"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Este
                            mes</button>
                        <button @click="setPreset('ano')"
                            class="px-3 py-1.5 text-xs font-medium rounded-lg border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">Este
                            año</button>
                    </div>
                </div>
            </div>

            {{-- ── Filtro de fechas + resumen de totales ──────────────────── --}}
            @livewire('admin.inicio.dashboard')

            {{-- ── Tablas y cards: stock, clientes, dispositivos, tickets, WO --}}
            @livewire('admin.inicio.dashboard-graficas')

            {{-- ── Lista de reportes: GPS, monitoreo, suspensiones, etc. ───── --}}
            @livewire('admin.inicio.dashboard-reportes')

        </div>

    </div>
</x-admin-layout>
