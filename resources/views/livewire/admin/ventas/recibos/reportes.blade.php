<div>
    <x-form.modal.card title="REPORTE DE RECIBOS" max-width="2xl" wire:model.live="openModalReporte" align="center">

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
                                <x-form.radio id="lg" lg wire:model.live="estado" value="PAID" name="estado"
                                    label="PAGADO" />

                            </div>
                            <div class="m-3">

                                <x-form.radio id="lg" lg wire:model.live="estado" value="UNPAID" name="estado"
                                    label="POR PAGAR" />
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

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click="closeModal" />
                <x-form.button positive label="Exportar" wire:click="ExportReport" spinner="ExportReport" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
