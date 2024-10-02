<x-form.modal.card title="VEHICULOS DE PLATAFORMA" blur wire:model.live="openModal" align="start" max-width="5xl">

    <div>
        <div class="flex justify-between items-center mb-4">
            <!-- Selector perPage a la izquierda -->
            <div class="w-auto">
                <x-form.select id="perPage" name="perPage" :options="[
                    ['name' => '10 por página', 'id' => 10],
                    ['name' => '25 por página', 'id' => 25],
                    ['name' => '50 por página', 'id' => 50],
                ]" option-label="name" option-value="id"
                    wire:model.live="perPage" :clearable="false" />


            </div>

            <!-- Buscador a la derecha -->
            <div class="w-auto">
                <input wire:model.live='search' id="action-search" class="form-input pl-9 focus:border-slate-300 w-auto"
                    type="search" placeholder="Buscar dispositivos" />
            </div>
        </div>
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">ID</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Nombre</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Placa</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">IMEI</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3">
                            <div class="font-semibold text-left">Estado</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">SIM</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Ultima Conexion</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Protocolo</div>
                        </th>

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    @foreach ($devices as $device)
                        <tr wire:key='vehi-{{ $device['id'] }}'>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ $device['id'] }}</div>
                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-slate-800">{{ $device['name'] }}</div>
                            </td>


                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <div class="font-medium text-sky-500">
                                    {{ $device['device_data']['plate_number'] }}

                                </div>

                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <div class="font-medium text-slate-800">{{ $device['device_data']['imei'] }}</div>

                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-{{ $device['icon_color'] }}-800 text-center">
                                    {{ $device['online'] }}
                                </div>
                            </td>

                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <div class="font-medium text-slate-800">{{ $device['device_data']['sim_number'] }}
                                </div>

                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <div class="font-medium text-slate-800">
                                    {{ $device['time'] }}
                                </div>

                            </td>
                            <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                <div class="font-medium text-slate-800">
                                    {{ $device['protocol'] }}
                                </div>

                            </td>
                        </tr>
                    @endforeach

                    @if (count($devices) < 1)
                        <td colspan="10" class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                            <div class="text-center">No hay Registros</div>
                        </td>
                    @endif


                </tbody>
            </table>

        </div>


    </div>

    <x-slot name="footer">
        <div class="mt-4 flex items-center justify-between">
            <!-- Mostrar la página actual -->
            <span>Página actual: {{ $page }}</span>

            <!-- Botones de paginación -->
            <div>


                <x-form.button wire:click.prevent='previousPage()' spinner="getDevices" label="Anterior" md />

                <x-form.button wire:click.prevent='nextPage()' spinner="getDevices" label="Siguiente" md />

            </div>
        </div>
    </x-slot>
</x-form.modal.card>
