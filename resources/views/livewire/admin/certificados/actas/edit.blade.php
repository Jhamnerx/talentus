<x-form.modal.card title="EDITAR ACTA" wire:model.live="openModalEdit" align="center" width="4xl">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-3">

            <x-form.input wire:model="numero" readonly label="Número Acta:" />

        </div>
        <div class="col-span-12 sm:col-span-5">

            <x-form.select autocomplete='off' label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent='addVehiculo(`${search}`)' x-on:click="close" primary flat full>
                        <span x-html="`Registrar Vehiculo <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>
        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.select autocomplete='off' label="Selecciona una Ciudad:" wire:model.live="ciudades_id"
                placeholder="Selecciona una ciudad" :async-data="route('api.ciudades.index')" option-label="nombre" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.datetime.picker label="Fecha Instalación:" id="fecha_instalacion" name="fecha_instalacion"
                wire:model.live="fecha_instalacion" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.datetime.picker label="Inicio de Cobertura:" id="inicio_cobertura" name="inicio_cobertura"
                wire:model.live="inicio_cobertura" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.datetime.picker label="Fin de Cobertura:" id="fin_cobertura" name="fin_cobertura"
                wire:model.live="fin_cobertura" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <label class="block text-sm font-medium mb-1" for="plataforma">Plataforma: <span
                    class="text-rose-500">*</span></label>
            <div class="flex flex-wrap items-center">

                <div class="m-3">
                    <label class="flex items-center">
                        <input type="radio" name="radio-buttons" class="form-radio" wire:model.live="plataforma"
                            value="basica" />
                        <span class="text-sm ml-2">Basica</span>
                    </label>
                </div>

                <div class="m-3">
                    <label class="flex items-center">
                        <input type="radio" name="radio-buttons" class="form-radio" wire:model.live="plataforma"
                            value="premium" />
                        <span class="text-sm ml-2">Premium</span>
                    </label>
                </div>

            </div>
            @error('plataforma')
                <p class="mt-2 text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="col-span-12 sm:col-span-12 mt-4">
            <span class="text-bold text-center mb-2">Caracteristicas:</span>
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                <div class="m-2 w-full mt-2">
                    <label for="fondo">Fondo:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="fondo" type="checkbox" id="fondo-1f" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="fondo-1f">
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
                            <input wire:model.live="sello" type="checkbox" id="sello-1d" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="sello-1d">
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
