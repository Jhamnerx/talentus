<x-form.modal.card title="LISTA DE SIM CARD'S DEL TECNICO" wire:model.defer="openModal" max-width="4xl" align="center">
    <div class="grid grid-cols-1">
        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                    <tr>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">SIM CARD</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">NUMERO ASIGNADO</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-left">OPERADOR</div>
                        </th>
                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                            <div class="font-semibold text-center">VEHICULO - DISPOSITIVO</div>
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
                    @if ($user)


                        @foreach ($sim_cards as $sim_card)
                            <tr wire:key="{{ $sim_card->id }}">


                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-talentus-100 rounded-full mr-2 sm:mr-3">

                                            <svg class="ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="20" height="20">
                                                <g fill="none" class="nc-icon-wrapper">
                                                    <path
                                                        d="M18 2h-8L4 8v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 2v16H6V8.83L10.83 4H18zM7 17h2v2H7v-2zm8 0h2v2h-2v-2zm-8-6h2v4H7v-4zm4 4h2v4h-2v-4zm0-4h2v2h-2v-2zm4 0h2v4h-2v-4z"
                                                        fill="white"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        @if (!empty($sim_card->sim_card))
                                            <div class="font-medium text-slate-800">{{ $sim_card->sim_card }}</div>
                                        @else
                                            <div class="font-medium text-slate-800"></div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    @if (!empty($sim_card->linea))
                                        <div class="text-left">{{ $sim_card->linea->numero }}</div>
                                    @else
                                        <div class="text-left"># -</div>
                                    @endif

                                </td>

                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left">{{ $sim_card->operador }}</div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                    @if (!empty($sim_card->vehiculos))
                                        <div class="flex items-center space-x-2 justify-center">
                                            <!-- Start -->
                                            <div class="relative" x-data="{ open: false }" @mouseenter="open = true"
                                                @mouseleave="open = false">
                                                <button class="block" aria-haspopup="true" :aria-expanded="open"
                                                    @focus="open = true" @focusout="open = false" @click.prevent>
                                                    <svg class="w-4 h-4 fill-current text-slate-400"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                                                    </svg>
                                                </button>
                                                <div class="z-10 absolute bottom-full left-1/2 -translate-x-1/2">
                                                    <div class="bg-slate-800 p-2 rounded overflow-hidden mb-2"
                                                        x-show="open"
                                                        x-transition:enter="transition ease-out duration-200 transform"
                                                        x-transition:enter-start="opacity-0 translate-y-2"
                                                        x-transition:enter-end="opacity-100 translate-y-0"
                                                        x-transition:leave="transition ease-out duration-200"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0" x-cloak>
                                                        <div class="text-xs text-slate-200 whitespace-nowrap">
                                                            Esta opción te permite ir al vehiculo asignado y
                                                            editarlo
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End -->
                                            <div class="font-medium text-sky-500">
                                                {{ $sim_card->vehiculos->placa }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="font-medium text-emerald-500">
                                            Sin Vehiculo
                                        </div>
                                    @endif

                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $sim_card->pivot->user->name }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $sim_card->pivot->created_at ? $sim_card->pivot->created_at->format('d-m-Y h:m') : '-' }}

                                    </div>
                                </td>
                                <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                                    <div class="text-left text-slate-800 text-sm">
                                        {{ $sim_card->created_at->format('d-m-Y h:m') }}

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        @if (count($sim_cards) < 1)
                            <tr>
                                <td colspan="7"
                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap col-span-full">
                                    <div class="text-center">No hay Registros</div>
                                </td>
                            </tr>
                        @endif
                    @endif


                </tbody>
            </table>

        </div>
        <!-- Pagination -->
        <div class="mt-8 w-full">
            @if ($user)
                {{ $sim_cards->links() }}
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
