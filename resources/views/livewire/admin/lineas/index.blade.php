<div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">LINEAS MOVILES✨</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Add  button -->
                @can('crear-sim_card')
                    <button wire:click.prevent="openModalCreate()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Registrar Linea</span>
                    </button>
                @endcan

                @can('asignar.linea-sim_card')
                    <button wire:click.prevent="openModalAsign"
                        class="btn btnAsignar bg-emerald-500 hover:bg-emerald-600 text-white btn border-slate-200 hover:border-slate-300">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path
                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                        </svg>
                        <span class="hidden xs:block ml-2">Asignar Sim Card a Linea</span>
                    </button>
                @endcan

            </div>

        </div>
        <!-- More actions -->

        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Right side -->
            <div class="sm:grid sm:grid-flow-col flex flex-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <div class="flex gap-1">

                    <!-- Export button -->
                    @can('exportar-sim_card')
                        <div class="relative float-right">

                            <button wire:click.prevent="openModalReporteLineas"
                                class="btn bg-emerald-600 hover:bg-emerald-700 text-white btn border-slate-200 hover:border-slate-300">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 32 32">
                                    <path
                                        d="M16 20c.3 0 .5-.1.7-.3l5.7-5.7-1.4-1.4-4 4V8h-2v8.6l-4-4L9.6 14l5.7 5.7c.2.2.4.3.7.3zM9 22h14v2H9z" />
                                </svg>
                                <span class="hidden xs:block ml-2">Generar Reporte</span>
                            </button>

                        </div>
                    @endcan

                </div>
                @if (Auth::user()->email == 'jhamnerx1x@gmail.com')
                    <div class="hidden">
                        <button class="btn hidden" wire:click="consulta"> consulta</button>
                    </div>
                @endif
            </div>

        </div>
        <!-- Table -->

        <livewire:admin.lineas.tabla />
    </div>
</div>

@push('scripts')
@endpush
