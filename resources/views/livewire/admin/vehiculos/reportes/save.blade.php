<x-form.modal.card title="CREAR REPORTE" wire:model.live="openModalSave" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-6">

            <x-form.select label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description"
                :async-data="route('api.vehiculos.index')" option-label="placa" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.datetime.picker label="Fecha Transmisión:" id="fecha_t" name="fecha_t" wire:model.live="fecha_t"
                without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY" :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.time-picker label="Hora Transmision:" placeholder="22:30" format="24" wire:model.live="hora_t" />
        </div>
        <div class="col-span-12">

            <label class="block text-sm font-medium mb-1" for="clientes_id">Selecciona:</label>
            <div class="m-3 flex gap-4">
                @foreach ($info->all() as $i)
                <x-form.radio left-label="{{ $i['detalle'] }}" id="md" md wire:model.live="text_add"
                    value="{{ $i['descripcion'] }}" />
                @endforeach
            </div>
        </div>
        <div class="col-span-12">
            <label class="block text-sm font-medium mb-1" for="clientes_id">Acciones:</label>
            <div class="m-3 flex gap-4">
                @foreach ($acciones->all() as $accion)
                <x-form.radio left-label="{{ $accion['detalle'] }}" id="md" md wire:model.live="accion"
                    value="{{ $accion['descripcion'] }}" />
                @endforeach
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