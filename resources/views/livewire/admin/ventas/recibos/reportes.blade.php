<div>

    <!-- Basic Modal -->

    <!-- Start -->
    <div x-data="{ openModalReporte: @entangle('openModalReporte').live }">
        <!-- Modal backdrop -->
        <div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-50 transition-opacity" x-show="openModalReporte"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-out duration-100"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" aria-hidden="true" x-cloak>
        </div>
        <!-- Modal dialog -->
        <div id="basic-modal"
            class="fixed inset-0 z-50 overflow-hidden flex items-center my-4 justify-center transform px-4 sm:px-6"
            role="dialog" aria-modal="true" x-show="openModalReporte"
            x-transition:enter="transition ease-in-out duration-200" x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak>

            <div class="bg-white rounded shadow-lg overflow-auto w-full md:w-3/4 lg:w-6/12 xl:w-6/12 2xl:w-1/3 max-h-full min-h-96"
                @keydown.escape.window="openModalReporte = false">
                <!-- Modal header -->
                <div class="px-5 py-3 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div class="font-semibold text-slate-800">REPORTE DE RECIBOS</div>
                        <button class="text-slate-400 hover:text-slate-500" @click="openModalReporte = false">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Modal content -->

                <form autocomplete="off" autocapitalize="true">


                    <div class="px-8 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-6 gap-2">
                                <x-form.datetime.picker label="Fecha Inicio:" id="fecha_inicio" name="fecha_inicio"
                                    wire:model.live="fecha_inicio" :min="now()->subYear(3)" :max="now()->addDays(30)" without-time
                                    parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />

                            </div>
                            <div class="col-span-6 gap-2">

                                <x-form.datetime.picker label="Fecha de Fin:" id="fecha_fin" name="fecha_fin"
                                    wire:model.live="fecha_fin" :min="now()->subYear(3)" :max="now()->addDays(30)" without-time
                                    parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
                            </div>

                            <div class="col-span-12 mt-2">
                                <label
                                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                    <div>
                                        Tipo de Pago:
                                    </div>

                                </label>
                                <div class="flex flex-wrap items-center -m-3">

                                    <div class="m-3">
                                        <x-form.radio id="lg" lg wire:model.live="estado" value="PAID"
                                            name="estado" label="PAGADO" />

                                    </div>
                                    <div class="m-3">

                                        <x-form.radio id="lg" lg wire:model.live="estado" value="UNPAID"
                                            name="estado" label="POR PAGAR" />
                                        <!-- End -->
                                    </div>

                                </div>

                            </div>

                            <div class="col-span-12 mt-2">
                                <label
                                    class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                                    <div>
                                        Totales:
                                    </div>
                                </label>
                                <div class="flex flex-wrap items-center -m-3">
                                    <div class="m-3 p-4 bg-gray-100 rounded-lg shadow-md">
                                        <span class="text-lg font-semibold">{{ number_format($total_dolares, 2) }}
                                            USD</span>
                                    </div>
                                    <div class="m-3 p-4 bg-gray-100 rounded-lg shadow-md">
                                        <span class="text-lg font-semibold">S/
                                            {{ number_format($total_soles, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>
                <!-- Modal footer -->
                <div class="px-5 py-4 border-t border-slate-200">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            wire:click="closeModal">Cerrar</button>

                        <x-form.button wire:click="ExportReport" spinner="ExportReport" positive label="Exportar" />

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End -->

</div>
