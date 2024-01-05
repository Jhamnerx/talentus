    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

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
                {{-- <ul class="flex flex-wrap -m-1">
                    <li class="m-1">
                        <button
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">
                            Todos
                            <span class="ml-1 text-indigo-200">67</span></button>
                    </li>
                    <li class="m-1">
                        <button
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                            Pagados
                            <span class="ml-1 text-slate-400">14</span></button>
                    </li>
                    <li class="m-1">
                        <button
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                            Pendientes
                            <span class="ml-1 text-slate-400">34</span></button>
                    </li>
                    <li class="m-1">
                        <button
                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                            Atrasados
                            <span class="ml-1 text-slate-400">19</span></button>
                    </li>
                </ul> --}}
            </div>

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

            </div>

        </div>

        <!-- Table -->
        <x-admin.facturacion.ventas-table :ventas="$ventas" />

        <!-- Pagination -->
        <div class="mt-8">
            {{ $ventas->links() }}
        </div>

    </div>
