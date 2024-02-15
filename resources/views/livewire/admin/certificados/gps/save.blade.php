<x-form.modal.card title="EMITIR ACTA" wire:model.live="openModalSave" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model="numero" readonly label="Número:" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.select label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.datetime-picker label="Fecha Instalación:" id="fecha_instalacion" name="fecha_instalacion"
                wire:model.live="fecha_instalacion" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.datetime-picker label="Fin de Cobertura:" id="fin_cobertura" name="fin_cobertura"
                wire:model.live="fin_cobertura" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.select label="Selecciona una Ciudad:" wire:model.live="ciudades_id"
                placeholder="Selecciona una ciudad" :async-data="route('api.ciudades.index')" option-label="nombre" option-value="id" />

        </div>


        <div class="col-span-12 sm:col-span-12 mt-4">
            <span class="text-bold text-center mb-2">Caracteristicas:</span>
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                <div class="m-2 w-full mt-2">
                    <label for="fondo">Fondo:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="fondo" type="checkbox" id="fondo-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="fondo-1">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">fondo switch</span>
                            </label>
                        </div>
                        <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Activado' : 'Desactivado'">
                        </div>
                    </div>

                </div>
                <div class="m-2 w-full">
                    <label for="sello">Sello:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="sello" type="checkbox" id="sello-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="sello-1">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">sello switch</span>
                            </label>
                        </div>
                        <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'Activado' : 'Desactivado'">
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-span-12 mt-2">
            <label
                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">
                <div>
                    Accesorios:
                </div>

            </label>
            <div class="flex flex-wrap items-center -m-3">

                <div class="m-3">

                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="accesorios" value="CORTE DE MOTOR"
                            class="form-checkbox" />
                        <span class="text-sm ml-2">CORTE DE MOTOR</span>
                    </label>

                </div>
                <div class="m-3">

                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="accesorios" value="BOTON DE PANICO"
                            class="form-checkbox" />
                        <span class="text-sm ml-2">BOTON DE PANICO</span>
                    </label>

                </div>
                <div class="m-3">

                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="accesorios" value="BUZZER" class="form-checkbox" />
                        <span class="text-sm ml-2">BUZZER</span>
                    </label>

                </div>
                <div class="m-3">

                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="accesorios" value="CIERRE DE PUERTA"
                            class="form-checkbox" />
                        <span class="text-sm ml-2">CIERRE DE PUERTAS</span>
                    </label>

                </div>
            </div>


            @error('accesorios')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror

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
