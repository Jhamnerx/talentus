<div>
    <x-form.modal.card title="CAMBIOS DE LA LINEA" max-width="7xl" wire:model.live="modalOpen">
        @if ($sim_card)


            <div class="bg-white shadow-lg rounded-sm border border-slate-200">
                <header class="px-5 py-4">
                    <h2 class="font-semibold text-slate-800">{{ $sim_card->sim_card }} <span
                            class="text-slate-400 font-medium"></span></h2>
                </header>
                <div>
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

                                @foreach ($cambios as $key => $cambio)
                                    <tr>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left font-medium text-sky-500">
                                                #{{ $key + 1 }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">{{ $cambio->tipo_cambio }}</div>
                                        </td>

                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left">{{ $cambio->sim_card->sim_card }}
                                            </div>
                                        </td>


                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            @if ($cambio->linea_old)
                                                <div class="text-left font-medium text-rose-500">+51
                                                    {{ $cambio->linea_old->numero }}</div>
                                            @else
                                                <div class="text-left font-medium text-rose-500">
                                                    Asignado
                                                    por 1° vez
                                                </div>
                                            @endif

                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-left font-medium text-emerald-500">
                                                @if ($cambio->linea_new)
                                                    +51 {{ $cambio->linea_new->numero }}
                                                @else
                                                    -
                                                @endif


                                            </div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-center">
                                                {{ $cambio->created_at->format('d-m-Y') }}</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-center">-</div>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                            <div class="text-center">{{ $cambio->users->name }}</div>
                                        </td>

                                    </tr>
                                @endforeach
                                @if ($cambios->count() < 1)
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
        @endif


        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
