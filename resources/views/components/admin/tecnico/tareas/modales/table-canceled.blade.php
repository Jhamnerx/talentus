<div class="bg-white shadow-lg rounded-sm border  border-slate-200 mt-6 ">
    <header class="px-5 py-4 block md:flex">
        <h2 class="font-semibold text-slate-800 flex-auto">Total Tareas: <span class="text-slate-400 font-medium">
                {{$tareas->total()}}
            </span>
        </h2>
        <div class="">

            <div class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model.live="search" class="form-input pl-9 w-full focus:border-slate-300" type="search"
                    placeholder="Buscar tarea" />

                <button type="button" class="absolute inset-0 right-auto group" type="button" aria-label="Search">
                    <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path
                            d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                    </svg>
                </button>
            </div>
        </div>


    </header>

    <div x-data="handleSelect">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-center">#</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-center">Tarea</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-center">Asignada por</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-center">Descripción</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Vehiculo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha Cancelacion</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Estado</div>
                        </th>
                        @can('tecnico.tareas.cards.canceled.actions')
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                        @endcan

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    @if ($tareas->count())
                    @foreach ($tareas as $tarea)
                    <tr>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left text-sky-700 hover:cursor-pointer hover:text-sky-800">
                                {{$tarea->token}}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                {{$tarea->tipo_tarea->nombre}}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                {{$tarea->user->name}}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="text-left font-medium text-slate-800 whitespace-normal min-w-3">
                                @switch($tarea->tipo_tarea_id)
                                @case(1)

                                Instalación de GPS {{$tarea->dispositivo}} en vehículo:
                                <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                                instalación: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                                <b>{{$tarea->fecha_hora->format('h:i A')}}</b>

                                @break

                                @case(2)
                                Cambio de chip en el vehículo: <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                                Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                                <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                                @break
                                @case(3)
                                Desinstalación de GPS {{$tarea->dispositivo}} en el vehículo:
                                <b>{{$tarea->vehiculo->placa}}</b>, Fecha Tarea:
                                <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                                <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                                @break
                                @case(4)
                                Instalación de Velocimetro <b>{{$tarea->modelo_velocimetro}}</b> en el vehículo:
                                <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                                Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                                <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                                @break
                                @case(5)
                                Mantenimiento GPS {{$tarea->dispositivo}} en el vehículo:
                                <b>{{$tarea->vehiculo->placa}}</b>, Fecha
                                Tarea: <b> {{$tarea->fecha_hora->format('d/m/Y')}}</b> - Hora:
                                <b>{{$tarea->fecha_hora->format('h:i A')}}</b>
                                @break

                                @endswitch
                            </div>
                        </td>

                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                {{$tarea->vehiculo->placa}}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                @if ($tarea->fecha_termino)
                                Cancelada el {{$tarea->fecha_termino->format('d-m-Y')}} a las
                                {{$tarea->fecha_termino->format('h:i A')}}
                                @else
                                error al obtener fecha

                                @endif

                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-left">

                                <div
                                    class="text-sm inline-flex font-medium bg-{{$tarea->estado->color()}}-100 text-{{$tarea->estado->color()}}-600 rounded-full text-center px-2.5 py-1">
                                    {{$tarea->estado->name()}}
                                </div>
                            </div>
                        </td>
                        @can('tecnico.tareas.cards.canceled.actions')
                        <td class="px-8 first:pl-5 last:pr-5 py-3 ">
                            <div class="flex gap-2 justify-center">
                                <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                    @mouseleave="open = false">
                                    <button type="button" wire:click.prevent="deleteTask({{$tarea->id}})"
                                        aria-haspopup="true" :aria-expanded="open" @focus="open = true"
                                        @focusout="open = false" @click.prevent type="button"
                                        class="btn rounded-full bg-rose-600 hover:bg-rose-700 text-white">
                                        <svg class="w-6 h-6 fill-current shrink-0" viewBox="0 0 32 32">
                                            <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                            <path
                                                d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                        </svg>
                                    </button>
                                    <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                        <div class="bg-slate-800 p-2 rounded overflow-hidden mb-2" x-show="open"
                                            x-transition:enter="transition ease-out duration-200 transform"
                                            x-transition:enter-start="opacity-0 translate-y-2"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-out duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            x-cloak>
                                            <div class="text-xs text-slate-200 whitespace-nowrap">
                                                Eliminar Tarea
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                    @else
                    <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                        <div class="text-center">No hay Registros</div>
                    </td>
                    @endif



                </tbody>
            </table>

        </div>
    </div>
</div>
