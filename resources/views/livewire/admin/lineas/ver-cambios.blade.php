<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ modalOpen: false }">

        <button @click="modalOpen = true" aria-controls="basic-modal"
            class="btn border-slate-200 hover:border-slate-300 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-check w-6 h-6 shrink-0"
                viewBox="0 0 32 32" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <circle cx="12" cy="12" r="2" />
                <path
                    d="M12 19c-4 0 -7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7c-.42 .736 -.858 1.414 -1.311 2.033" />
                <path d="M15 19l2 2l4 -4" />
            </svg>
        </button>
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalOpen"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class=" fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalOpen" x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>
            <div class="bg-white rounded shadow-lg overflow-auto max-w-screen-lg w-full max-h-full"
                @click.outside="modalOpen = false" @keydown.escape.window="modalOpen = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-bold text-slate-800">CAMBIOS DE LA LINEA: </div>
                        <div class="text-slate-800 text-sm"> </div>
                        <button class="text-slate-400 hover:text-slate-500" @click="modalOpen = false">
                            <div class="sr-only">Cerrar</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->
                <div class="relative mx-auto px-4 sm:px-6 lg:px-8 my-4">

                    <div class="bg-white shadow-lg rounded-sm border border-slate-200">
                        <header class="px-5 py-4">
                            <h2 class="font-semibold text-slate-800">{{$sim_card->sim_card}} <span
                                    class="text-slate-400 font-medium"></span></h2>
                        </header>
                        <div x-data="handleSelect">

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <!-- Table header -->
                                    <thead
                                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                        <tr>

                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">#</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Tipo de cambios</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Sim card</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Numero anterior</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold">Numero Nuevo</div>
                                            </th>

                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Fecha</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold text-left">Fecha Activacion</div>
                                            </th>
                                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="font-semibold">Usuario</div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody class="text-sm divide-y divide-slate-200">
                                        <!-- Row -->
                                        @if ($cambios->count())
                                        @foreach ($cambios as $cambio)
                                        <tr>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-left font-medium text-sky-500">#1</div>
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-left">{{$cambio->tipo_cambio}}</div>
                                            </td>

                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-left">{{$cambio->sim_card->sim_card}}</div>
                                            </td>


                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                @if ($cambio->linea_old)
                                                <div class="text-left font-medium text-rose-500">+51
                                                    {{$cambio->linea_old->numero}}</div>
                                                @else
                                                <div class="text-left font-medium text-rose-500">Asignado 1°</div>
                                                @endif

                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-left font-medium text-emerald-500">
                                                    @if ($cambio->linea_new)
                                                    +51 {{$cambio->linea_new->numero}}
                                                    @else
                                                    -
                                                    @endif


                                                </div>
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-center">{{$cambio->created_at}}</div>
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-center">-</div>
                                            </td>
                                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                <div class="text-center">{{$cambio->users->name}}</div>
                                            </td>

                                        </tr>
                                        @endforeach
                                        @else
                                        <td colspan="8"
                                            class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                            <div class="text-center">No hay Cambios en este Sim Card</div>
                                        </td>
                                        @endif
                                        <!-- Row -->

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>




                </div>

                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            @click="modalOpen = false">Cerrar</button>
                        <button wire:click='save'
                            class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

</div>