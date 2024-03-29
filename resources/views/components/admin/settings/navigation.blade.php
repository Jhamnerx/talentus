<div
    class="flex flex-nowrap overflow-x-scroll no-scrollbar md:block md:overflow-auto px-3 py-6 border-b md:border-b-0 md:border-r border-slate-200 min-w-60 md:space-y-3">
    <!-- Group 1 -->
    <div>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-3">Ajustes del Sistema</div>
        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                    :class="settingsPanel === 'account' && 'bg-indigo-50'" href="{{ route('admin.ajustes.cuenta') }}">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                        :class="settingsPanel === 'account' && 'text-indigo-400'" viewBox="0 0 16 16">
                        <path
                            d="M12.311 9.527c-1.161-.393-1.85-.825-2.143-1.175A3.991 3.991 0 0012 5V4c0-2.206-1.794-4-4-4S4 1.794 4 4v1c0 1.406.732 2.639 1.832 3.352-.292.35-.981.782-2.142 1.175A3.942 3.942 0 001 13.26V16h14v-2.74c0-1.69-1.081-3.19-2.689-3.733zM6 4c0-1.103.897-2 2-2s2 .897 2 2v1c0 1.103-.897 2-2 2s-2-.897-2-2V4zm7 10H3v-.74c0-.831.534-1.569 1.33-1.838 1.845-.624 3-1.436 3.452-2.422h.436c.452.986 1.607 1.798 3.453 2.422A1.943 1.943 0 0113 13.26V14z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600"
                        :class="settingsPanel === 'account' ? 'text-indigo-500' : 'hover:text-slate-700'">
                        Mi Cuenta
                    </span>
                </a>
            </li>
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                    :class="settingsPanel === 'notifications' && 'bg-indigo-50'"
                    href="{{ route('admin.ajustes.notificaciones') }}">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                        :class="settingsPanel === 'notifications' && 'text-indigo-400'" viewBox="0 0 16 16">
                        <path
                            d="M14.3.3c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-8 8c-.2.2-.4.3-.7.3-.3 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l8-8zM15 7c.6 0 1 .4 1 1 0 4.4-3.6 8-8 8s-8-3.6-8-8 3.6-8 8-8c.6 0 1 .4 1 1s-.4 1-1 1C4.7 2 2 4.7 2 8s2.7 6 6 6 6-2.7 6-6c0-.6.4-1 1-1z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600"
                        :class="settingsPanel === 'notifications' ? 'text-indigo-500' : 'hover:text-slate-700'">
                        Mis Notificaciones
                    </span>
                </a>
            </li>
            @can('admin.settings.ciudades.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        :class="settingsPanel === 'ciudades' && 'bg-indigo-50'"
                        href="{{ route('admin.ajustes.ciudades') }}">

                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                            :class="settingsPanel === 'ciudades' && 'text-indigo-400'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-slate-600"
                            :class="settingsPanel === 'ciudades' ? 'text-indigo-500' : 'hover:text-slate-700'">Ciudades</span>
                    </a>
                </li>
            @endcan

            @can('admin.settings.roles.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        :class="settingsPanel === 'roles' && 'bg-indigo-50'" href="{{ route('admin.ajustes.roles') }}">

                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                            :class="settingsPanel === 'roles' && 'text-indigo-400'" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="text-sm font-medium text-slate-600"
                            :class="settingsPanel === 'roles' ? 'text-indigo-500' : 'hover:text-slate-700'">Roles</span>
                    </a>
                </li>
            @endcan
            @can('admin.settings.series.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.series') }}"
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        :class="settingsPanel === 'series' && 'bg-indigo-50'">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                            :class="settingsPanel === 'series' && 'text-indigo-400'" viewBox="0 0 16 16">
                            <path
                                d="M15 4c.6 0 1 .4 1 1v10c0 .6-.4 1-1 1H3c-1.7 0-3-1.3-3-3V3c0-1.7 1.3-3 3-3h7c.6 0 1 .4 1 1v3h4zM2 3v1h7V2H3c-.6 0-1 .4-1 1zm12 11V6H2v7c0 .6.4 1 1 1h11zm-3-5h2v2h-2V9z" />
                        </svg>
                        <span class="text-sm font-medium text-slate-600"
                            :class="settingsPanel === 'series' ? 'text-indigo-500' : 'hover:text-slate-700'">Series
                            Comprobantes</span>
                    </a>
                </li>
            @endcan
            @can('admin.settings.plantilla.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.plantilla') }}"
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        :class="settingsPanel === 'plantilla' && 'bg-indigo-50'">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                            :class="settingsPanel === 'plantilla' && 'text-indigo-400'" viewBox="0 0 16 16">
                            <path
                                d="M15 4c.6 0 1 .4 1 1v10c0 .6-.4 1-1 1H3c-1.7 0-3-1.3-3-3V3c0-1.7 1.3-3 3-3h7c.6 0 1 .4 1 1v3h4zM2 3v1h7V2H3c-.6 0-1 .4-1 1zm12 11V6H2v7c0 .6.4 1 1 1h11zm-3-5h2v2h-2V9z" />
                        </svg>
                        <span class="text-sm font-medium text-slate-600"
                            :class="settingsPanel === 'plantilla' ? 'text-indigo-500' : 'hover:text-slate-700'">Plantilla</span>
                    </a>
                </li>
            @endcan
            @can('admin.settings.plantilla.index')
                <li class="mr-0.5 md:mr-0 md:mb-0.5">
                    <a href="{{ route('admin.ajustes.sunat') }}"
                        class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                        :class="settingsPanel === 'sunat' && 'bg-indigo-50'">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                            :class="settingsPanel === 'sunat' && 'text-indigo-400'" viewBox="0 0 16 16">
                            <path
                                d="M15 4c.6 0 1 .4 1 1v10c0 .6-.4 1-1 1H3c-1.7 0-3-1.3-3-3V3c0-1.7 1.3-3 3-3h7c.6 0 1 .4 1 1v3h4zM2 3v1h7V2H3c-.6 0-1 .4-1 1zm12 11V6H2v7c0 .6.4 1 1 1h11zm-3-5h2v2h-2V9z" />
                        </svg>
                        <span class="text-sm font-medium text-slate-600"
                            :class="settingsPanel === 'sunat' ? 'text-indigo-500' : 'hover:text-slate-700'">
                            Ajustes Sunat
                        </span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>
    <!-- Group 2 -->
    {{-- <div>
        <div class="text-xs font-semibold text-slate-400 uppercase mb-3">Experience</div>
        <ul class="flex flex-nowrap md:block mr-3 md:mr-0">
            <li class="mr-0.5 md:mr-0 md:mb-0.5">
                <a class="flex items-center px-2.5 py-2 rounded whitespace-nowrap"
                    :class="settingsPanel === 'feedback' && 'bg-indigo-50'" href="feedback.html">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 mr-2"
                        :class="settingsPanel === 'feedback' && 'text-indigo-400'" viewBox="0 0 16 16">
                        <path
                            d="M7.001 3h2v4h-2V3zm1 7a1 1 0 110-2 1 1 0 010 2zM15 16a1 1 0 01-.6-.2L10.667 13H1a1 1 0 01-1-1V1a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1zM2 11h9a1 1 0 01.6.2L14 13V2H2v9z" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600"
                        :class="settingsPanel === 'feedback' ? 'text-indigo-500' : 'hover:text-slate-700'">Give
                        Feedback</span>
                </a>
            </li>
        </ul>
    </div> --}}
</div>
