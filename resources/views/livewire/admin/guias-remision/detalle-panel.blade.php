<div class="absolute inset-0 sm:left-auto z-20 shadow-xl duration-200 ease-in-out"
    :class="detallePanelOpen ? 'translate-x-0' : 'translate-x-full'" @click.outside="detallePanelOpen = false"
    @keydown.escape.window="detallePanelOpen = false" x-cloak x-data="{ detallePanelOpen: @entangle('detallePanelOpen').live }"
    @set-detallePanelOpen="detallePanelOpen = $event.detail">
    <div
        class="sticky top-16 bg-slate-50 overflow-x-hidden overflow-y-auto no-scrollbar shrink-0 border-l border-slate-200 w-full sm:w-[430px] h-[calc(100vh-64px)]">

        <button class="absolute top-0 right-0 mt-6 mr-6 group p-2" @click="detallePanelOpen = false">
            <svg class="w-4 h-4 fill-slate-400 group-hover:fill-slate-600" viewBox="0 0 16 16"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m7.95 6.536 4.242-4.243a1 1 0 1 1 1.415 1.414L9.364 7.95l4.243 4.242a1 1 0 1 1-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 0 1-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 0 1 1.414-1.414L7.95 6.536Z" />
            </svg>
        </button>
        @if ($guia)
            <div class="py-8 px-4 lg:px-8">
                <div class="max-w-sm mx-auto lg:max-w-none">

                    <div class="text-slate-800 font-semibold text-center mb-1">Detalle Guia Remisión</div>
                    <div class="text-sm text-center italic">{{ $guia->fecha_emision->format('d/m/Y, h:i A') }}</div>

                    <!-- Details -->
                    <div class="drop-shadow-lg mt-12">
                        <!-- Top -->
                        <div class="bg-white rounded-t-xl px-5 pb-2.5 text-center">
                            <div class="mb-3 text-center">
                                <img class="inline-flex w-12 h-12 rounded-full -mt-6"
                                    src="{{ asset('images/transactions-image-04.svg') }}" width="48" height="48"
                                    alt="Transaction 04" />
                            </div>
                            <div class="text-2xl font-semibold text-emerald-500 mb-1">
                                {{ $guia->serie_numero }}
                            </div>
                            <div class="text-sm font-medium text-slate-800 mb-3">
                                {{ $guia->razon_social }}</div>
                            <div
                                class="text-xs inline-flex font-medium bg-slate-100 text-slate-500 rounded-full text-center px-2.5 py-1">
                                {{ $guia->numero_documento }}</div>
                        </div>
                        <!-- Divider -->
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
                        <!-- Bottom -->

                        <div class="bg-white rounded-b-xl p-5 pt-2.5 text-sm space-y-3">
                            <div class="flex justify-between space-x-1">

                                <span class="font-medium text-slate-700 text-center">CODIGO</span>
                                <span class="font-medium text-slate-700 text-center">PRODUCTO</span>
                                <span class="font-medium text-slate-700 text-center">CANT</span>
                            </div>


                            @foreach ($guia->detalle as $detalle)
                                <div class="flex justify-between space-x-1">
                                    <span class="font-medium text-slate-700 text-right">{{ $detalle->codigo }}</span>
                                    <span
                                        class="font-medium text-slate-700 text-right">{{ $detalle->descripcion }}</span>
                                    <span class="font-medium text-slate-700 text-right">{{ $detalle->cantidad }}</span>
                                </div>
                            @endforeach

                            @if ($guia->detalle->count() < 1)
                                <div class="flex justify-between space-x-1">
                                    <span class="font-medium text-slate-700 text-center">
                                        No hay detalle de items
                                    </span>
                                </div>
                            @endif


                        </div>

                    </div>

                    <!-- Notas -->

                    @if ($guia)
                    @endif
                    <div class="drop-shadow-lg mt-12">
                        <!-- Bottom -->

                        <div class="bg-white rounded-b-xl p-5 pt-2.5 text-sm space-y-3">
                            <div class="flex justify-between space-x-1">

                                <span class="font-medium text-slate-700 text-center">IMEI</span>
                                <span class="font-medium text-slate-700 text-center">MODELO</span>
                                <span class="font-medium text-slate-700 text-center">TECNICO</span>
                            </div>

                            @if ($guia->dispositivos->count())
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-slate-200">
                                        @foreach ($guia->dispositivos as $dispositivo)
                                            <tr>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $dispositivo->imei }}</span>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $dispositivo->modelo->modelo }}</span>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $guia->user->name }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="flex justify-between space-x-1">
                                    <span class="font-medium text-slate-700 text-center">
                                        No hay detalle de items
                                    </span>
                                </div>
                            @endif


                        </div>

                    </div>

                    {{-- SIM CARDS LIST --}}

                    <div class="drop-shadow-lg mt-12">
                        <!-- Bottom -->

                        <div class="bg-white rounded-b-xl p-5 pt-2.5 text-sm space-y-3">
                            <div class="flex justify-between space-x-1">

                                <span class="font-medium text-slate-700 text-center">SIM CARD</span>
                                <span class="font-medium text-slate-700 text-center">OPERADOR</span>
                                <span class="font-medium text-slate-700 text-center">TECNICO</span>

                            </div>
                            @if ($guia->sim_cards->count())
                                <table class="table-auto w-full">
                                    <tbody class="text-sm divide-y divide-slate-200">

                                        @foreach ($guia->sim_cards as $sim_card)
                                            <tr>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $sim_card->sim_card }}</span>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $sim_card->operador }}</span>
                                                </td>
                                                <td
                                                    class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap text-center">
                                                    <span
                                                        class="font-medium text-slate-700 text-right">{{ $guia->user->name }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="flex justify-between space-x-1">
                                    <span class="font-medium text-slate-700 text-center">
                                        No hay detalle de items
                                    </span>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Download / Report -->
                    <div class="flex items-center space-x-3 mt-6">
                        <div class="w-1/2">
                            <button wire:click.prevent='closeDetallePanel'
                                class="btn w-full border-slate-200 hover:border-slate-300 text-rose-500">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                    <path
                                        d="M7.001 3h2v4h-2V3Zm1 7a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM15 16a1 1 0 0 1-.6-.2L10.667 13H1a1 1 0 0 1-1-1V1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1ZM2 11h9a1 1 0 0 1 .6.2L14 13V2H2v9Z" />
                                </svg>
                                <span class="ml-2">Cancelar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
