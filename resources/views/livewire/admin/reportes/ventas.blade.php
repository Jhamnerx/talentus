<x-form.modal.card title="Reporte Ventas" name="showModal" wire:model.live="showModal" align="center" persistent>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Tipo comprobante:" id="tipo_comprobante_id" name="tipo_comprobante_id" :options="[
                ['name' => 'FACTURA ELECTRONICA', 'id' => '01'],
                ['name' => 'BOLETA ELECTRONICA', 'id' => '03'],
                ['name' => 'N. VENTA ELECTRONICA', 'id' => '02'],
            ]"
                placeholder="Selecciona un tipo (opcional)" option-label="name" option-value="id"
                wire:model.live="tipo_comprobante_id" />
        </div>

        <div class="col-span-12 md:col-span-6">
            <x-form.select autocomplete="off" id="cliente_id" name="cliente_id" label="Selecciona un cliente:"
                wire:model.live="cliente_id" placeholder="Escriba el nombre o número de documento del cliente"
                :async-data="[
                    'api' => route('api.clientes.index'),
                    'params' => ['local_id' => session('local_id')],
                ]" option-label="razon_social" option-value="id" option-description="numero_documento">

            </x-form.select>
        </div>

        <div class="col-span-6">
            <x-form.datetime.picker label="Fec. Emision:" id="fecha_inicio" name="fecha_inicio"
                wire:model.live="fecha_inicio" :min="now()->subYears(5)" :max="now()" without-time
                parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
        </div>
        <div class="col-span-6">
            <x-form.datetime.picker label="Fec. Emision:" id="fecha_fin" name="fecha_fin" wire:model.live="fecha_fin"
                :min="$fecha_inicio" :max="now()" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
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
                <div class="m-3">

                    <x-form.radio id="lg" lg wire:model.live="estado" value="Todos" name="estado"
                        label="POR PAGAR" />
                    <!-- End -->
                </div>

            </div>

        </div>

        <div
            class="flex items-center justify-center col-span-12 bg-gray-100 shadow-md cursor-pointer  dark:bg-secondary-700 rounded-lg gap-4 py-4">


            <x-form.button icon="clipboard" secondary label="EXCEl" wire:click.prevent="exportar" spinner="exportar" />
            {{-- <x-form.button icon="clipboard" secondary label="PDF" /> --}}
        </div>

    </div>

    <x-slot name="footer" class="flex justify-between gap-x-4">

        <div class="flex gap-x-4">
            <x-form.button flat label="Cancelar" x-on:click="close" />

        </div>
    </x-slot>
</x-form.modal.card>
