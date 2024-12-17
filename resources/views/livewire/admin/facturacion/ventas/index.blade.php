    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">VENTAS ✨</h1>
            </div>

        </div>

        <!-- More actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-5">

            <!-- Left side -->
            <div class="mb-4 sm:mb-0">
                <div class="contenedor-estados-sunat flex flex-wrap -m-1">
                    <div class="sunat-estado m-1">
                        <label class="estadosunat">
                        </label>

                        Estados SUNAT:
                    </div>
                    <div><label class="aceptado"></label>Aceptado</div>
                    <div><label class="rechazado"></label>Rechazado</div>
                    <div><label class="noenviado"></label>Pendiente de envío</div>
                    <div><label class="baja"></label>Comunicación de baja(Anulado)</div>
                </div>
            </div>
            <button wire:click.prevent="openModalReporteVentas()" type="button"
                class="btn bg-sky-500 hover:bg-sky-600 dark:bg-sky-700 dark:hover:bg-sky-800 text-white">
                <svg class="w-5 h-5 fill-current shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                    <g stroke-width="2" fill="none" class="nc-icon-wrapper">
                        <polyline data-cap="butt" points="56 20 39 20 39 3" stroke="#fff" stroke-miterlimit="10">
                        </polyline>
                        <polygon points="56 20 56 61 8 61 8 3 39 3 56 20" stroke="#fff" stroke-linecap="square"
                            stroke-miterlimit="10"></polygon>
                        <line x1="19" y1="49" x2="45" y2="49" stroke="#fff"
                            stroke-linecap="square" stroke-miterlimit="10"></line>
                        <line x1="19" y1="39" x2="45" y2="39" stroke="#fff"
                            stroke-linecap="square" stroke-miterlimit="10"></line>
                        <line x1="19" y1="29" x2="45" y2="29" stroke="#fff"
                            stroke-linecap="square" stroke-miterlimit="10"></line>
                        <line x1="19" y1="19" x2="30" y2="19" stroke="#fff"
                            stroke-linecap="square" stroke-miterlimit="10"></line>
                    </g>
                </svg>
                <span class="hidden xs:block ml-2 text-xs">REPORTE VENTAS</span>
            </button>

            <!-- Right side -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                <!-- Search form -->

                <form class="relative">
                    <label for="action-search" class="sr-only">Search</label>
                    <input name="serie_correlativo" id="action-search" class="form-input pl-9 focus:border-slate-300"
                        type="search" wire:model.live="search" placeholder="Buscar Factura o Boleta…" />
                    <button type="button" class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                            viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                            <path
                                d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                </form>

                <!-- Create invoice button -->
                @canany(['comprobantes-emitir-factura', 'comprobantes-emitir-boleta'])
                    <a href="{{ route('admin.factura.create') }}">
                        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
                            <svg class="w-4 h-4 fill-current opacity-50 shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span class="hidden xs:block ml-2">Emitir</span>
                        </button>
                    </a>
                @endcanany

            </div>

        </div>

        <!-- Table -->
        <x-admin.facturacion.ventas-table :ventas="$ventas" />

        <!-- Pagination -->
        <div class="mt-8">
            {{ $ventas->links() }}
        </div>

    </div>
