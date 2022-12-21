<div class="bg-white shadow-lg rounded-sm border  border-slate-200 mt-6 ">
    <header class="px-5 py-4 block md:flex">
        <h2 class="font-semibold text-slate-800 flex-auto">Total Tareas: <span class="text-slate-400 font-medium">
                {{$tareas->total()}}
            </span>
        </h2>
        <div class="">

            <div class="relative">
                <label for="action-search" class="sr-only">Buscar</label>
                <input wire:model="search" class="form-input pl-9 w-full focus:border-slate-300" type="search"
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
                            <div class="font-semibold text-center">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha Termino</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Acciones</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Subir Imagen</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Validacion</div>
                        </th>
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
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="text-center ">
                                {{$tarea->user->name }}
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-normal min-w-36">
                            <div class="text-left font-medium text-slate-800">
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
                            <div class="text-left">

                                <div
                                    class="text-sm inline-flex font-medium bg-{{$tarea->estado->color()}}-100 text-{{$tarea->estado->color()}}-600 rounded-full text-center px-2.5 py-1">
                                    {{$tarea->estado->name()}}
                                </div>
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="text-center">
                                @if ($tarea->fecha_termino)
                                Terminada el {{$tarea->fecha_termino->format('d-m-Y')}} a las
                                {{$tarea->fecha_termino->format('h:i A')}}
                                @else
                                error al obtener fecha

                                @endif

                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 ">
                            <div class="flex gap-2 justify-center">
                                <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                    @mouseleave="open = false">
                                    <button wire:click="sendWhatsApp({{$tarea->id}})" aria-haspopup="true"
                                        :aria-expanded="open" @focus="open = true" @focusout="open = false"
                                        @click.prevent type="button"
                                        class="rounded-full bg-emerald-600 hover:bg-emerald-700">
                                        <svg class="w-8 h-8 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                            aria-label="WhatsApp" role="img" viewBox="0 0 512 512">
                                            <rect width="512" height="512" rx="15%"
                                                fill='{{!$tarea->sent_message ? "#25d366" : "#67DF93"}}'
                                                stroke="#fff" />
                                            <path fill='{{!$tarea->sent_message ? "#25d366" : "#67DF93"}}' stroke="#fff"
                                                stroke-width="26" d="M123 393l14-65a138 138 0 1150 47z" />
                                            <path fill="#fff"
                                                d="M308 273c-3-2-6-3-9 1l-12 16c-3 2-5 3-9 1-15-8-36-17-54-47-1-4 1-6 3-8l9-14c2-2 1-4 0-6l-12-29c-3-8-6-7-9-7h-8c-2 0-6 1-10 5-22 22-13 53 3 73 3 4 23 40 66 59 32 14 39 12 48 10 11-1 22-10 27-19 1-3 6-16 2-18" />
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
                                            <div class="text-xs text-slate-200 whitespace-nowrap">Enviar Mensaje
                                                WhatsApp</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3 max-w-xs" x-data="{ isUploading: false, progress: 0 }"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">

                            @if ($tarea->image)
                            {{-- <button wire:click="verImagen" class="btn bg-emerald-700 text-white">VER</button> --}}
                            <a class="image-task btn bg-emerald-700 text-white" data-gall="gallery01"
                                href="{{Storage::url($tarea->image->url)}}">VER</a>
                            @else
                            <div x-show="!isUploading" class="flex gap-2 justify-center hover:cursor-pointer">
                                <label class="block hover:cursor-pointer">
                                    <input type="file" wire:model="imagen.{{$tarea->id}}"
                                        class=" hover:cursor-pointer  text-sm font-normal text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </label>
                            </div>
                            <div x-show="isUploading">
                                {{-- <progress max="100" x-bind:value="progress"></progress> --}}
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                                    <div class="bg-emerald-600 h-2.5 rounded-full dark:bg-emerald-500"
                                        :style="`width: ${progress}%`">
                                    </div>
                                </div>
                            </div>

                            @endif


                        </td>
                        <td class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="text-center">
                                @if ($tarea->respuesta)

                                <img src="{{asset('images/valid.png')}}" class="w-7" alt="">
                                @else
                                <img src="{{asset('images/invalid.png')}}" class="w-7" alt="">
                                @endif
                            </div>
                        </td>

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
