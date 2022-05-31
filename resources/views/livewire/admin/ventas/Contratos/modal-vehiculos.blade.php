<div wire:ignore>
    <div class="detallesvehiculos">

        @if (!empty($detalles) )
        @foreach ($detalles as $detalle)

        <div class="filas flex -mx-1 px-2 py-4 border-b box-border" id="fila{{$loop->index}}"
            idvehiculo="{{$detalle->vehiculos->id}}">

            <div class="flex-auto px-1 md:px-5 lg:px-5 xl:w-32 text-left">
                <p class="text-gray-800 xs:text-base">{{$detalle->vehiculos->placa}}</p>
                <input type="hidden" class="idvehiculo" idvehiculo="{{$detalle->vehiculos->id}}"
                    name="items[{{$loop->index}}][vehiculos_id]" value="{{$detalle->vehiculos->id}}">

            </div>

            <div class="flex-auto xl:w-28 text-left">
                <input class="form-input w-16 md:w-28 lg:w-28" type="text" name="items[{{$loop->index}}][plan]"
                    value="{{$detalle->plan}}">
            </div>
            <div class="flex-auto xl:w-20 text-center">
                <button type="button" class="text-red-500 hover:text-red-600 text-sm font-semibold"
                    onclick="eliminarDetalleVehiculos({{$loop->index}})">Eliminar</button>
            </div>
        </div>
        @endforeach
        @else

        @endif




    </div>
    <!-- Basic Modal -->
    <!-- Start -->
    <div x-data="{ modalVehiculos: @entangle('openModalVehiculos') }">
        <button type="button"
            class="btnAgregarVehiculo mt-6 bg-white hover:bg-gray-100 text-gray-700 font-semibold py-2 px-4 text-sm border border-gray-300 rounded shadow-sm"
            @click.prevent="modalVehiculos = true" aria-controls="basic-modal">Añadir Vehiculo</button>

        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="modalVehiculos"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="modalVehiculos"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-6/12 max-h-full"
                @keydown.escape.window="modalVehiculos = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">ELIGE LOS VEHICULOS</div>
                        <button class="text-slate-400 hover:text-slate-500" @click.prevent="modalVehiculos = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>


                <!-- Modal content -->
                <div class="px-1 md:px-4 py-2 bg-white sm:p-2">
                    <div class="px-2 md:px-4 sm:px-6 lg:px-4 py-2 w-full max-w-9xl mx-auto">

                        <!-- Table -->
                        <div class="bg-white shadow-lg rounded-sm border border-slate-200 mb-8">
                            <header class="px-5 py-3">
                                <h2 class="font-semibold text-slate-800">vehiculos <span
                                        class="text-slate-400 font-medium"></span>
                                </h2>
                            </header>
                            <div>

                                <!-- Table -->
                                <div class="overflow-x-auto" wire:ignore>
                                    <table class="table-auto w-full pb-8" id="example">
                                        <!-- Table header -->
                                        <thead
                                            class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                            <tr>
                                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-semibold text-left">#</div>
                                                </th>
                                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Placa</div>
                                                </th>
                                                <th
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden md:table-cell">
                                                    <div class="font-semibold text-left">Flota</div>
                                                </th>
                                                <th
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden lg:table-cell">
                                                    <div class="font-semibold text-left">SIM#</div>
                                                </th>
                                                <th
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden lg:table-cell">
                                                    <div class="font-semibold text-left">Dispositivo#</div>
                                                </th>
                                                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-semibold text-left">Acciones</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- Table body -->
                                        <tbody class="text-sm divide-y divide-slate-200">
                                            <!-- Row -->
                                            @if ($vehiculos->count())
                                            @foreach ($vehiculos as $vehiculo)

                                            <tr>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-blue-500">
                                                        {{$vehiculo->id}}
                                                    </div>



                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                                    <div class="font-medium text-blue-500">
                                                        {{$vehiculo->placa}}
                                                    </div>



                                                </td>

                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden md:table-cell">
                                                    <div class="font-medium text-sky-500">
                                                        {{$vehiculo->flotas->nombre}}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden lg:table-cell">
                                                    <div class="font-medium text-slate-800">
                                                        {{$vehiculo->sim_card->linea->numero}}</div>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap hidden lg:table-cell">
                                                    <div class="font-medium text-slate-800">
                                                        {{$vehiculo->dispositivos->modelo->modelo." |
                                                        ".$vehiculo->dispositivos->imei}}
                                                    </div>
                                                </td>
                                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                                    <div class="m-3 ">
                                                        <!-- Start -->
                                                        <button type="button"
                                                            class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 border border-gray-700 rounded shadow-sm"
                                                            onclick="agregarVehiculo({{$vehiculo}})">
                                                            Añadir
                                                        </button>
                                                        <!-- End -->
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

                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">

                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- End -->

</div>

@push('scripts')




@endpush