<x-form.modal.card title="REPORTE DE TAREAS" wire:model.live="openModalReporte" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-6 gap-2">
            <x-form.datetime-picker label="Fecha Inicial:" id="fecha_inicial" name="fecha_inicial"
                wire:model.live="fecha_inicial" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        <div class="col-span-12 md:col-span-6 gap-2">
            <x-form.datetime-picker label="Fecha Final:" id="fecha_final" name="fecha_final"
                wire:model.live="fecha_final" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-12 md:col-span-6 gap-2">
            <label
                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                <div>Estado: <span class="text-sm text-red-500"> * </span></div>

            </label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <select wire:model.live="estado" class="form-select w-full pl-9" id="">
                    <option value="PENDIENT">PENDIENTE</option>
                    <option value="UNREAD">SIN LEER</option>
                    <option value="COMPLETE" selected>COMPLETADAS</option>
                    <option value="CANCELED">CANCELADAS</option>
                </select>
            </div>
        </div>
        <div class="col-span-12">
            <label class="block text-sm font-medium mb-1" for="plataforma">Selecciona El Tecnico:
                <span class="text-rose-500">*</span></label>
            <div class="flex flex-wrap items-center">

                @foreach ($tecnicos as $tecnico)
                    <div class="m-3">
                        <label class="flex items-center">
                            <input type="radio" name="radio-buttons" class="form-radio" wire:model.live="tecnico_id"
                                value="{{ $tecnico->id }}" />
                            <span class="text-sm ml-2">{{ $tecnico->name }}</span>
                        </label>
                    </div>
                @endforeach

            </div>
            @error('tecnico_id')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="col-span-12 text-center">

            <div class="flex flex-wrap items-center -m-1.5">
                <div class="flex flex-wrap -space-x-px gap-3 text-center">

                    <x-form.button label="EXCEL" positive md wire:click.prevent="exportToExcel"
                        spinner="exportToExcel" />
                    <x-form.button label="PDF" red md wire:click.prevent="exportToPdf" spinner="exportToPdf" />

                </div>
            </div>

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click.prevent='closeModal' />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
