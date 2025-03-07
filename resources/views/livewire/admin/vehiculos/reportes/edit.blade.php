<x-form.modal.card title="CREAR REPORTE" wire:model.live="openModalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-6">

            <x-form.select disabled label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.datetime.picker label="Fecha Transmisión:" id="fecha_t" name="fecha_t" wire:model.live="fecha_t"
                without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.time.picker military-time without-seconds label="Hora Transmision:" placeholder="22:30"
                wire:model.live="hora_t" />
        </div>
        <div class="col-span-12 sm:col-span-12 mt-4">
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">
                <div class="">
                    <button type="button" wire:click.prevent="changeStatus(1)"
                        class="w-full text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        SOLUCIONAR
                    </button>
                </div>
                <div>
                    <button type="button" wire:click.prevent="changeStatus(2)"
                        class="w-full text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                        EN ESPERA
                    </button>
                </div>
                <div class="">
                    <button type="button" wire:click.prevent="changeStatus(3)"
                        class="w-full text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        SOLUCIONADO
                    </button>
                </div>



            </div>
        </div>
        <div class="col-span-12 sm:col-span-12">
            <x-form.textarea label="Detalle:" wire:model.live='detalle' placeholder="Ingresar Breve Descripcíon" />
        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
