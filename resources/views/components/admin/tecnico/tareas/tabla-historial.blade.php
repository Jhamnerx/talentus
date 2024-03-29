<div class="bg-white shadow-lg rounded-sm border  border-slate-200 mt-6 ">
    <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">Total Tareas: <span
                class="text-slate-400 font-medium">{{ $tareas->total() }}</span>
        </h2>
    </header>
    <div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                            <div class="flex items-center">
                                <label class="inline-flex">
                                    <span class="sr-only">Select all</span>
                                    <input id="parent-checkbox" class="form-checkbox" type="checkbox" />
                                </label>
                            </div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-left">#</div>
                        </th>
                        @role('admin')
                            <th class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="font-semibold text-left">Tecnico</div>
                            </th>
                        @endrole
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-center">Descripción</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">Vehiculo</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">CLIENTE</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Estado</div>
                        </th>
                        @role('admin')
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Costo</div>
                            </th>
                        @endrole
                        @canany(['tecnico.tareas.edit', 'tecnico.tareas.delete', 'tecnico.tareas.action.pdf'])
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Acciones</div>
                            </th>
                        @endcanany

                        @can('tecnico.tareas.action.wsp')
                            <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-semibold text-center">Notificar</div>
                            </th>
                        @endcan
                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->

                    @foreach ($tareas as $tarea)
                        <tr wire:key='th-{{ $tarea->id }}'>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                <div class="flex items-center">
                                    <label class="inline-flex">
                                        <span class="sr-only">Select</span>
                                        <input class="table-item form-checkbox" id-tarea="{{ $tarea->id }}"
                                            type="checkbox" />
                                    </label>
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div wire:click.prevent="infoTask"
                                    class="text-left text-sky-700 hover:cursor-pointer hover:text-sky-800">
                                    {{ $tarea->token }}
                                </div>
                            </td>
                            @role('admin')
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <x-form.badge flat black label="  {{ $tarea->tecnico->name }}" />

                                </td>
                            @endrole
                            <td class="px-2 first:pl-5 last:pr-5 py-3">
                                <div class="text-left font-medium text-slate-800">
                                    @php
                                        $datos = [
                                            '%placa%' => '<b>' . $tarea->vehiculo->placa . '</b>',
                                            '%velo_modelo%' => '<b>' . $tarea->modelo_velocimetro . '</b>',
                                            '%fecha%' => '<b>' . $tarea->fecha_hora->format('d/m/Y') . '</b>',
                                            '%modelo_gps%' => '<b>' . $tarea->dispositivo . '</b>',
                                            '%hora%' => '<b>' . $tarea->fecha_hora->format('h:i A') . '</b>',
                                        ];

                                        $info = strtr($tarea->tipo_tarea->descripcion, $datos);
                                    @endphp
                                    {!! $info !!}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-center">
                                    {{ $tarea->vehiculo->placa }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 ">
                                <div class="text-center">
                                    {{ $tarea->vehiculo->cliente ? $tarea->vehiculo->cliente->razon_social : '' }}
                                </div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="text-left">

                                    <div
                                        class="text-sm inline-flex font-medium bg-{{ $tarea->estado->color() }}-100 text-{{ $tarea->estado->color() }}-600 rounded-full text-center px-2.5 py-1">
                                        {{ $tarea->estado->name() }}
                                    </div>
                                </div>
                            </td>
                            @role('admin')
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-center">
                                        {{ $tarea->tipo_tarea->costo }}
                                    </div>
                                </td>
                            @endrole
                            @canany(['tecnico.tareas.edit', 'tecnico.tareas.delete', 'tecnico.tareas.action.pdf'])
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex gap-2 justify-center">
                                        @can('tecnico.tareas.action.pdf')
                                            <a target="_blank" href="{{ route('admin.pdf.tarea', $tarea) }}">
                                                <button type="button" class="btn bg-rose-600 hover:bg-rose-700 text-white">
                                                    <svg class="w-6 h-6 fill-current shrink-0"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                        <g fill="none" class="nc-icon-wrapper">
                                                            <path
                                                                d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm12 6V9c0-.55-.45-1-1-1h-2v5h2c.55 0 1-.45 1-1zm-2-3h1v3h-1V9zm4 2h1v-1h-1V9h1V8h-2v5h1v-2zm-8 0h1c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1H9v5h1v-2zm0-2h1v1h-1V9z"
                                                                fill="currentColor"></path>
                                                        </g>
                                                    </svg>
                                                </button>
                                            </a>
                                        @endcan
                                        @can('tecnico.tareas.edit')
                                            <button type="button" wire:click.prevent="openModalInform({{ $tarea->id }})"
                                                class="btn bg-white hover:bg-slate-300 text-black">
                                                <svg class="w-6 h-6 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 64 64">
                                                    <g stroke-linecap="round" stroke-width="2" fill="none"
                                                        stroke="currentColor" stroke-linejoin="round" class="nc-icon-wrapper">
                                                        <polyline data-cap="butt" points="56 20 39 20 39 3"></polyline>
                                                        <polygon points="56 20 56 61 8 61 8 3 39 3 56 20"></polygon>
                                                        <line x1="19" y1="49" x2="45" y2="49">
                                                        </line>
                                                        <line x1="19" y1="39" x2="45" y2="39">
                                                        </line>
                                                        <line x1="19" y1="29" x2="45" y2="29">
                                                        </line>
                                                        <line x1="19" y1="19" x2="30" y2="19">
                                                        </line>
                                                    </g>
                                                </svg>
                                            </button>

                                            <button type="button" wire:click.prevent="editTask({{ $tarea->id }})"
                                                class="btn bg-orange-600 hover:bg-orange-700 text-white">

                                                <svg class="w-6 h-6 fill-current shrink-0" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 48 48">
                                                    <g stroke-linecap="square" stroke-width="2" fill="none"
                                                        stroke="currentColor" stroke-linejoin="miter" class="nc-icon-wrapper"
                                                        stroke-miterlimit="10">
                                                        <line x1="29" y1="9" x2="39" y2="19">
                                                        </line>
                                                        <path
                                                            d="M17,41,3,45,7,31,34.121,3.879a3,3,0,0,1,4.243,0l5.757,5.757a3,3,0,0,1,0,4.243Z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('tecnico.tareas.delete')
                                            <button type="button" wire:click.prevent="deleteTask({{ $tarea->id }})"
                                                class="btn bg-rose-600 hover:bg-rose-700 text-white">
                                                <svg class="w-6 h-6 fill-current shrink-0" viewBox="0 0 32 32">
                                                    <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                                    <path
                                                        d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany

                            @can('tecnico.tareas.action.wsp')
                                <td class="px-2 first:pl-5 last:pr-5 py-3 ">
                                    <div class="flex gap-2 justify-center">
                                        <button wire:click="notifyTecnico({{ $tarea->id }})" type="button"
                                            wire:loading.attr="disabled" wire:loading.class="bg-emerald-400"
                                            wire:loading.class.remove="hover:bg-emerald-70 bg-emerald-700"
                                            class="rounded-full bg-emerald-600 hover:bg-emerald-700">
                                            <svg class="w-10 h-10 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                                aria-label="WhatsApp" role="img" viewBox="0 0 512 512">
                                                <rect width="512" height="512" rx="15%" fill="#25d366" />
                                                <path fill="#25d366" stroke="#fff" stroke-width="26"
                                                    d="M123 393l14-65a138 138 0 1150 47z" />
                                                <path fill="#fff"
                                                    d="M308 273c-3-2-6-3-9 1l-12 16c-3 2-5 3-9 1-15-8-36-17-54-47-1-4 1-6 3-8l9-14c2-2 1-4 0-6l-12-29c-3-8-6-7-9-7h-8c-2 0-6 1-10 5-22 22-13 53 3 73 3 4 23 40 66 59 32 14 39 12 48 10 11-1 22-10 27-19 1-3 6-16 2-18" />
                                            </svg>

                                        </button>
                                    </div>
                                </td>
                            @endcan


                        </tr>
                    @endforeach
                    @if ($tareas->count() < 1)
                        <td colspan="7" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                            <div class="text-center">No hay Registros</div>
                        </td>
                    @endif



                </tbody>
            </table>

        </div>
    </div>
</div>
