<x-form.modal.card title="LISTA DE DISPOSITIVOS DEL TECNICO" wire:model.defer="openModal" max-width="4xl" align="center">
    <div class="grid grid-cols-1">
        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">IMEI</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">MODELO</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">MARCA</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">VEHICULO</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">ENVIADO POR:</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha Envio:</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">Fecha registro:</div>
                        </th>

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-slate-200">
                    <!-- Row -->
                    @if ($user)

                        @foreach ($dispositivos as $dispositivo)
                            <tr wire:key="devicet-{{ $dispositivo->id }}">

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-100 rounded-full mr-2 sm:mr-3">
                                            @if ($dispositivo->modelo->image)
                                                <img class="ml-1"
                                                    src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp"
                                                    width="20" height="20" alt="Icon 01" />
                                            @else
                                                {{-- <img class="ml-1"
                                            src="{{ Storage::url($dispositivo->modelo->image->url) }}.webp" width="20"
                                            height="20" alt="Icon 01" /> --}}
                                            @endif

                                        </div>
                                        @if ($dispositivo->of_client)
                                            <div class="font-medium text-blue-400">{{ $dispositivo->imei }}</div>
                                        @else
                                            <div class="font-medium text-slate-800">{{ $dispositivo->imei }}</div>
                                        @endif

                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $dispositivo->modelo->modelo }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $dispositivo->modelo->marca }}</div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">

                                    @if (!empty($dispositivo->vehiculos))
                                        <div class="font-medium text-sky-500">
                                            {{ $dispositivo->vehiculos->placa }}
                                        </div>
                                    @else
                                        <div class="font-medium text-emerald-500">
                                            Equipo Disponible
                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $dispositivo->pivot->user->name }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $dispositivo->pivot->created_at ? $dispositivo->pivot->created_at->format('d-m-Y h:m') : '-' }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $dispositivo->created_at->format('d-m-Y h:m') }}

                                    </div>
                                </td>

                            </tr>

                            @if ($dispositivos->count() < 1)
                                <td colspan="7"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            @endif
                        @endforeach
                    @endif

                </tbody>
            </table>

        </div>
        <!-- Pagination -->
        <div class="mt-8 w-full">
            @if ($user)
                {{ $dispositivos->links() }}
            @endif

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">

            <div></div>
            <div class="flex">
                <x-form.button flat label="Cerrar" x-on:click="close" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
