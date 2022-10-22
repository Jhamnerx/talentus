<div class="absolute inset-0 sm:left-auto z-20 shadow-xl duration-200 ease-in-out"
    :class="vehiculosPanelOpen ? 'translate-x-0' : 'translate-x-full'"
    @keydown.escape.window="vehiculosPanelOpen = false" x-cloak>
    <div
        class="sticky top-16 bg-slate-50 overflow-x-hidden overflow-y-auto no-scrollbar shrink-0 border-l border-slate-200 w-full sm:w-[460px] h-[calc(100vh-64px)]">

        <button type="button" class="absolute top-0 right-0 mt-6 mr-6 group p-2"
            @click.prevent="vehiculosPanelOpen = false">
            <svg class="w-4 h-4 fill-slate-400 group-hover:fill-slate-600" viewBox="0 0 16 16"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m7.95 6.536 4.242-4.243a1 1 0 1 1 1.415 1.414L9.364 7.95l4.243 4.242a1 1 0 1 1-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 0 1-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 0 1 1.414-1.414L7.95 6.536Z" />
            </svg>
        </button>

        <div class="py-8 px-4 lg:px-8">
            <div class="max-w-sm mx-auto lg:max-w-none">

                <div class="text-slate-800 font-semibold text-center mb-1">SELECCIONA LOS VEHICULOS</div>
                <!-- Details -->
                <div class="drop-shadow-lg mt-12">
                    <!-- Top -->
                    <div class="bg-white rounded-t-xl px-5 pb-2.5 text-center">
                        <div class="mb-3 text-center">
                            <div class="inline-flex w-12 h-12 rounded-full -mt-6 bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <g class="nc-icon-wrapper">
                                        <path
                                            d="M11,45H5a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,11,45Z"
                                            fill="#363636"></path>
                                        <path
                                            d="M43,45H37a1,1,0,0,1-1-1V36a1,1,0,0,1,1-1h6a1,1,0,0,1,1,1v8A1,1,0,0,1,43,45Z"
                                            fill="#363636"></path>
                                        <path
                                            d="M42,21,40.415,7.533A4,4,0,0,0,36.443,4H11.557A4,4,0,0,0,7.585,7.533L6,21Z"
                                            fill="#e3e3e3"></path>
                                        <path
                                            d="M42,22a1,1,0,0,1-.992-.883L39.422,7.649A3,3,0,0,0,36.442,5H11.558a3,3,0,0,0-2.98,2.649L6.993,21.117a1,1,0,0,1-1.986-.234L6.592,7.415A5,5,0,0,1,11.558,3H36.442a5,5,0,0,1,4.966,4.415l1.585,13.468a1,1,0,0,1-.876,1.11A.945.945,0,0,1,42,22Z"
                                            fill="#38a838"></path>
                                        <path
                                            d="M46,38H2a1,1,0,0,1-1-1V26a6,6,0,0,1,6-6H41a6,6,0,0,1,6,6V37A1,1,0,0,1,46,38Z"
                                            fill="#78d478"></path>
                                        <circle cx="40" cy="27" r="3" fill="#fff"></circle>
                                        <circle cx="8" cy="27" r="3" fill="#fff"></circle>
                                        <path d="M31,31H17a2,2,0,0,1,0-4H31a2,2,0,0,1,0,4Z" fill="#363636"></path>
                                        <path
                                            d="M1,34H47a0,0,0,0,1,0,0v3a1,1,0,0,1-1,1H2a1,1,0,0,1-1-1V34A0,0,0,0,1,1,34Z"
                                            fill="#49c549"></path>
                                        <circle cx="8" cy="34" r="2" fill="#f7bf26"></circle>
                                        <circle cx="40" cy="34" r="2" fill="#f7bf26"></circle>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <div class="text-sm font-medium text-slate-800 mb-3">
                            01</div>
                        <div
                            class="text-xs inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-1">
                            Vehiculos</div>
                    </div>
                    <div class="flex justify-between items-center" aria-hidden="true">
                        <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                        </svg>
                        <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                            <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                        </div>
                        <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                        </svg>
                    </div>



                    <div class="bg-white rounded-b-xl p-5 pt-2.5 text-sm space-y-3 text-center">

                        @if ($cliente)
                            <input wire:model='search' class="form-input pl-9 focus:border-slate-300" type="search"
                                placeholder="Buscar contrato…" />
                        @endif







                        <div class="overflow-x-auto">
                            <table class="table-auto w-full" @click.stop="$dispatch('vehiculosPanelOpen', true)">

                                <thead
                                    class="text-xs font-semibold  content-center uppercase text-slate-500 border-t border-b border-slate-200">
                                    <tr>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-center">#</div>
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-center">Placa</div>
                                        </th>


                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="font-semibold text-center">Acciones</div>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-slate-200 border-b border-slate-200">

                                    @if ($vehiculos)
                                        @foreach ($vehiculos as $vehiculo)
                                            <tr>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-blue-500 text-center">
                                                        {{ $vehiculo->id }}
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-blue-500 text-center">
                                                        {{ $vehiculo->placa }}
                                                    </div>
                                                </td>

                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                                    <div class="m-3 text-center">

                                                        <button type="button"
                                                            wire:click.prevent="agregarVehiculo({{ $vehiculo->id }})"
                                                            class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded shadow-sm">
                                                            Añadir
                                                        </button>

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td colspan="10"
                                            class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                            <div class="text-center">No hay Registros</div>
                                        </td>
                                    @endif



                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
