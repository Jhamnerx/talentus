<div
    class="flex flex-nowrap overflow-x-scroll no-scrollbar md:block md:overflow-auto px-3 py-6 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700/60 min-w-60 md:space-y-3">
    <!-- Group 1 -->
    <div>
        <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-3">Ajustes del Sistema</div>
        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.cuenta')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif"
                    href="{{ route('admin.ajustes.cuenta') }}">
                    <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.cuenta')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                        width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M8 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm-5.143 7.91a1 1 0 1 1-1.714-1.033A7.996 7.996 0 0 1 8 10a7.996 7.996 0 0 1 6.857 3.877 1 1 0 1 1-1.714 1.032A5.996 5.996 0 0 0 8 12a5.996 5.996 0 0 0-5.143 2.91Z" />
                    </svg>
                    <span
                        class="text-sm font-medium @if (Route::is('admin.ajustes.cuenta')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                        Mi Cuenta
                    </span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.notificaciones')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif"
                    href="{{ route('admin.ajustes.notificaciones') }}">
                    <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.notificaciones')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                        width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="m9 12.614 4.806 1.374a.15.15 0 0 0 .174-.21L8.133 2.082a.15.15 0 0 0-.268 0L2.02 13.777a.149.149 0 0 0 .174.21L7 12.614V9a1 1 0 1 1 2 0v3.614Zm-1 1.794-5.257 1.503c-1.798.514-3.35-1.355-2.513-3.028L6.076 1.188c.791-1.584 3.052-1.584 3.845 0l5.848 11.695c.836 1.672-.714 3.54-2.512 3.028L8 14.408Z" />
                    </svg>
                    <span
                        class="text-sm font-medium @if (Route::is('admin.ajustes.notificaciones')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                        Mis Notificaciones
                    </span>
                </a>
            </li>
            @can('admin.settings.ciudades.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.ciudades')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif"
                        href="{{ route('admin.ajustes.ciudades') }}">
                        <svg class="w-4 h-4 shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.ciudades')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-sm font-medium @if (Route::is('admin.ajustes.ciudades')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Ciudades
                        </span>
                    </a>
                </li>
            @endcan

            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.operadores')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif"
                    href="{{ route('admin.ajustes.operadores') }}">
                    <svg class="w-4 h-4 shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.operadores')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1.5 8.322a10.5 10.5 0 0 1 21 0l-1.497.089a9 9 0 0 0-18.006 0L1.5 8.322Z" />
                        <path d="M4.5 11.322a7.5 7.5 0 0 1 15 0l-1.498.089a6 6 0 0 0-12.004 0L4.5 11.322Z" />
                        <path d="M7.5 14.322a4.5 4.5 0 0 1 9 0l-1.5.088a3 3 0 0 0-6 0l-1.5-.088Z" />
                        <path d="M10.5 17.322a1.5 1.5 0 0 1 3 0h-3Z" />
                    </svg>
                    <span class="text-sm font-medium @if (Route::is('admin.ajustes.operadores')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                        Operadores
                    </span>
                </a>
            </li>

            @can('admin.settings.roles.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.roles')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif"
                        href="{{ route('admin.ajustes.roles') }}">
                        <svg class="w-4 h-4 shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.roles')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-medium @if (Route::is('admin.ajustes.roles')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Roles
                        </span>
                    </a>
                </li>
            @endcan
            @can('admin.settings.series.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.series') }}"
                        class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.series')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                        <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.series')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            width="16" height="16" viewBox="0 0 16 16">
                            <path
                                d="M14.5 0h-13A.5.5 0 0 0 1 .5v15a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V.5a.5.5 0 0 0-.5-.5ZM3 4h10v1H3V4Zm0 3h10v1H3V7Zm0 3h10v1H3v-1Z" />
                        </svg>
                        <span
                            class="text-sm font-medium @if (Route::is('admin.ajustes.series')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Series Comprobantes
                        </span>
                    </a>
                </li>
            @endcan
            @role('admin')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.sla') }}"
                        class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.sla')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                        <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.sla')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            width="16" height="16" viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0Zm0 14A6 6 0 1 1 8 2a6 6 0 0 1 0 12Zm.5-9H7v4l3.5 2.1.5-.8-3-1.8V5Z" />
                        </svg>
                        <span
                            class="text-sm font-medium @if (Route::is('admin.ajustes.sla')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Perfiles SLA
                        </span>
                    </a>
                </li>
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.firebase') }}"
                        class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.firebase')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                        <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.firebase')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            width="16" height="16" viewBox="0 0 16 16">
                            <path
                                d="M3 13l2-11 3 5 2-3 3 9H3Zm5-6.5L6.5 9 8 10l1.5-1L8 6.5Z" />
                        </svg>
                        <span
                            class="text-sm font-medium @if (Route::is('admin.ajustes.firebase')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Credenciales Firebase
                        </span>
                    </a>
                </li>
            @endrole
            @can('admin.settings.plantilla.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.plantilla') }}"
                        class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.plantilla')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                        <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.plantilla')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            width="16" height="16" viewBox="0 0 16 16">
                            <path
                                d="M14.5 1h-13a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5ZM3 13V9h10v4H3Zm10-6H3V3h10v4Z" />
                        </svg>
                        <span
                            class="text-sm font-medium @if (Route::is('admin.ajustes.plantilla')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Plantilla
                        </span>
                    </a>
                </li>
            @endcan
            @can('admin.settings.plantilla.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.sunat') }}"
                        class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.sunat')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                        <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.sunat')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                            width="16" height="16" viewBox="0 0 16 16">
                            <path
                                d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1Z" />
                        </svg>
                        <span
                            class="text-sm font-medium @if (Route::is('admin.ajustes.sunat')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                            Ajustes Sunat
                        </span>
                    </a>
                </li>
            @endcan
            
            <!-- Bancos y Cuentas Bancarias -->
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a href="{{ route('admin.ajustes.bancos') }}"
                    class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.bancos')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                    <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.bancos')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                        width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M8 0 0 3v1h16V3L8 0ZM2 6h2v6H2V6Zm4 0h2v6H6V6Zm4 0h2v6h-2V6ZM0 14h16v2H0v-2Z" />
                    </svg>
                    <span
                        class="text-sm font-medium @if (Route::is('admin.ajustes.bancos')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                        Bancos
                    </span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a href="{{ route('admin.ajustes.cuentas-bancarias') }}"
                    class="flex items-center px-2.5 py-2 rounded-lg whitespace-nowrap @if (Route::is('admin.ajustes.cuentas-bancarias')) {{ 'bg-linear-to-r from-violet-500/12 dark:from-violet-500/24 to-violet-500/' }} @endif">
                    <svg class="shrink-0 fill-current mr-2 @if (Route::is('admin.ajustes.cuentas-bancarias')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                        width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M2 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v1H2V4Zm0 3v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H2Zm3 3a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                    </svg>
                    <span
                        class="text-sm font-medium @if (Route::is('admin.ajustes.cuentas-bancarias')) {{ 'text-violet-500 dark:text-violet-400' }}@else{{ 'text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }} @endif">
                        Cuentas Bancarias
                    </span>
                </a>
            </li>

        </ul>
    </div>
</div>
