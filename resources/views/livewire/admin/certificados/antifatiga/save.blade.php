<x-form.modal.card title="EMITIR CERTIFICADO ANTIFATIGA" wire:model.live="openModalSave" align="center" width="4xl">

    <div class="grid grid-cols-12 gap-6">


        <div class="col-span-12 sm:col-span-4">

            <x-form.select autocomplete='off' label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id" x-on:selected="$wire.getDispositivosDelVehiculo()">

                <x-slot name="beforeOptions" class="p-2 flex justify-center" x-show="displayOptions.length === 0">
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
            <x-form.datetime.picker label="Fecha Emisión:" id="fecha_emision" name="fecha_emision"
                wire:model.live="fecha_emision" without-time parse-format="YYYY-MM-DD" display-format="DD-MM-YYYY"
                :clearable="false" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <div class="flex items-center mb-1">
                <label class="block text-sm font-medium">Cliente:</label>
                <div class="ml-auto">
                    <label class="flex items-center cursor-pointer">
                        <div class="form-switch">
                            <input type="checkbox" id="cambiar-cliente" class="sr-only"
                                wire:click="toggleCambiarCliente" x-data="{}"
                                x-bind:checked="$wire.cambiar_cliente" />
                            <label class="bg-slate-400" for="cambiar-cliente"
                                :class="{ 'bg-primary-500': $wire.cambiar_cliente, 'bg-slate-400': !$wire.cambiar_cliente }">
                                <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                <span class="sr-only">cambiar cliente switch</span>
                            </label>
                        </div>
                        <span class="text-sm ml-2">Cambiar cliente</span>
                    </label>
                </div>
            </div>
            <div x-data="{}" x-cloak>
                <x-form.select autocomplete='off' wire:model.live="cliente_id" placeholder="Selecciona un cliente"
                    option-description="numero_documento" :async-data="route('api.clientes.index')" option-label="razon_social"
                    option-value="id" :disabled="!$cambiar_cliente" />
            </div>

            @error('cliente_id')
                <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-12 sm:col-span-6">
            <div>
                <div>
                    @if ($vehiculos_id)

                        @if (empty($dispositivos))
                            <div class="text-red-500 text-sm p-2">
                                No hay dispositivos asociados a este vehículo
                            </div>
                        @else
                            <x-form.select label="Seleccionar dispositivo:" autocomplete='off' name="dispositivo_imei"
                                id="dispositivo_imei" wire:model.live="dispositivo_id"
                                placeholder="Seleccionar dispositivo" :options="$dispositivos" option-label="imei"
                                option-description="option_description" option-value="id" />
                        @endif
                    @else
                        <span>No hay vehículo seleccionado</span>
                    @endif
                </div>
            </div>
            @error('imei_personalizado')
                <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
            @enderror
            @error('dispositivo_imei')
                <p class="mt-2 text-pink-600 text-sm">{{ $message }}</p>
            @enderror
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
