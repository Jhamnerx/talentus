<x-form.modal.card title="EDITAR CERTIFICADO VELOCIMETRO" wire:model.live="openModalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-3">

            <x-form.input wire:model="numero" readonly label="Número Certificado:" />

        </div>
        <div class="col-span-12 sm:col-span-5">

            <x-form.select label="Selecciona una Vehiculo:" wire:model.live="vehiculos_id"
                placeholder="Selecciona una placa" option-description="option_description" :async-data="route('api.vehiculos.index')"
                option-label="placa" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-4">

            <x-form.select label="Selecciona una Ciudad:" wire:model.live="ciudades_id"
                placeholder="Selecciona una ciudad" :async-data="route('api.ciudades.index')" option-label="nombre" option-value="id" />

        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.select label="Modelo
                                    Velocimetro:"
                placeholder="Selecciona un modelo" wire:model.live="velocimetro_modelo">
                @foreach ($velocimetros as $velocimetro)
                    <x-select.option label="{{ $velocimetro->descripcion }}" value="{{ $velocimetro->descripcion }}" />
                @endforeach
            </x-form.select>

        </div>
        <div class="col-span-12">

            <label class="block text-sm font-medium mb-1" for="observacion">OBSERVACIÓN:</label>
            <div class="relative">
                <textarea wire:model.live="observacion" class="form-input w-full pl-9" name="observacion" id="observacion"
                    rows="4" placeholder="Ingresar Observación"></textarea>
                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">

                    <svg class="w-4 h-4 fill-current text-slate-400 shrink-0 ml-3 mr-2"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                        <g class="nc-icon-wrapper">
                            <path
                                d="M15,33,6.293,30.274a1,1,0,0,0-.255.433l-4,14a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l14-4a.994.994,0,0,0,.433-.255Z"
                                fill="#fbe5d5"></path>
                            <path d="M28.586,7.981,6.293,30.274,17.707,41.688,40,19.4Z" fill="#ff7163">
                            </path>
                            <path d="M3.3,40.3l-1.26,4.409a1,1,0,0,0,.688,1.236,1.007,1.007,0,0,0,.548,0l4.409-1.26Z"
                                fill="#4c4c4c"></path>
                            <path d="M34.3,13.7,12.01,35.99l5.7,5.7L40,19.4Z" fill="#f74b3b">
                            </path>
                            <path
                                d="M44.828,8.91,39.07,3.153a4.093,4.093,0,0,0-5.656,0l-4.63,4.631L40.2,19.2l4.63-4.631a4,4,0,0,0,0-5.657Z"
                                fill="#3d6c7b"></path>
                            <rect x="33.294" y="5.618" width="2" height="16.142"
                                transform="translate(0.365 28.258) rotate(-45)" fill="#2a4b55">
                            </rect>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-12 mt-4">
            <span class="text-bold text-center mb-2">Caracteristicas:</span>
            <div class=" grid grid-cols-1 sm:grid-cols-3 gap-4 content-center">

                <div class="m-2 w-full mt-2">
                    <label for="fondo">Fondo:</label>

                    <div class="flex items-center" x-data="{ checked: true }">
                        <div class="form-switch">
                            <input wire:model.live="fondo" type="checkbox" id="fondoe-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="fondoe-1">
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
                            <input wire:model.live="sello" type="checkbox" id="selloe-1" class="sr-only"
                                x-model="checked" />
                            <label class="bg-slate-400" for="selloe-1">
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
