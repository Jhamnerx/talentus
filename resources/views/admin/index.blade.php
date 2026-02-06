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

        <!-- Alerta de Movimientos Sin Destino -->
        @php
            $movimientosSinDestino = \App\Models\GlobalPayment::whereNull('destination_id')->count();
        @endphp
        @if ($movimientosSinDestino > 0)
            <div class="mb-6">
                <div
                    class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-600 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                Movimientos financieros sin destino asignado
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <p>
                                    Hay <strong class="font-bold">{{ $movimientosSinDestino }}</strong>
                                    {{ $movimientosSinDestino === 1 ? 'movimiento' : 'movimientos' }}
                                    que no {{ $movimientosSinDestino === 1 ? 'tiene' : 'tienen' }} asignada una caja o
                                    cuenta bancaria.
                                    {{ $movimientosSinDestino === 1 ? 'Este movimiento fue' : 'Estos movimientos fueron' }}
                                    registrado{{ $movimientosSinDestino === 1 ? '' : 's' }}
                                    cuando no había cajas abiertas o cuentas disponibles.
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('admin.movimientos') }}?destination_type=sin_destino"
                                    class="inline-flex items-center px-4 py-2 border border-yellow-600 dark:border-yellow-400 rounded-md shadow-sm text-sm font-medium text-yellow-800 dark:text-yellow-200 bg-yellow-100 dark:bg-yellow-900/40 hover:bg-yellow-200 dark:hover:bg-yellow-900/60 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                    <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                    Asignar destinos ahora
                                </a>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button type="button"
                                class="inline-flex rounded-md text-yellow-400 hover:text-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                                onclick="this.closest('div').parentElement.parentElement.parentElement.remove()">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Avatars -->
            @livewire('admin.inicio.avatars')

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">


                <div class="relative">
                    <input
                        class="datepicker form-input pl-9 text-slate-500 hover:text-slate-600 font-medium focus:border-slate-300 w-60"
                        placeholder="Select dates" data-class="flatpickr-right" />
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 fill-current text-slate-500 ml-3" viewBox="0 0 16 16">
                            <path
                                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z" />
                        </svg>
                    </div>
                </div>


            </div>

        </div>

        <!-- Cards -->
        @livewire('admin.inicio.cards')


    </div>
</x-admin-layout>
