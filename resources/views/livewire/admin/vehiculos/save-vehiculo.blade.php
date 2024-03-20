<x-form.modal.card title="REGISTRAR VEHICULO" blur wire:model.live="modalCreate" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="placa" wire:input="convertirAMayusculas" label="Placa Unidad:"
                placeholder="ABC-780" />
        </div>

        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="marca" label="Marca:" placeholder="TOYOTA" />
        </div>


        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="modelo" label="Modelo:" placeholder="HILUX" />
        </div>

        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="tipo" label="Tipo:" placeholder="PICK UP" />
        </div>

        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="year" label="Año:" placeholder="2024" />
        </div>
        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="color" label="COLOR:" placeholder="ROJO AZUL BLANCO" />
        </div>
        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="motor" label="MOTOR:" placeholder="1GDG066086" />
        </div>
        <div class="col-span-6 sm:col-span-6">

            <x-form.input wire:model.live="serie" label="SERIE:" placeholder="8AJHA8CD9K2629775" />
        </div>
        <div class="col-span-12 sm:col-span-12">

            <x-form.select label="Selecciona un cliente:" wire:model.live="clientes_id"
                placeholder="Selecciona un cliente" option-description="numero_documento" :async-data="route('api.clientes.index')"
                option-label="razon_social" option-value="id">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" x-on:click="close" primary flat
                        full>
                        <span x-html="`Crear cliente <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>
        </div>

        @if ($flotas)
            <div class="col-span-12 sm:col-span-12">
                <label class="block text-sm font-medium mb-1" for="clientes_id">Flotas:</label>

                <div class="grid grid-cols-12 gap-6">
                    @foreach ($flotas as $flota)
                        <div class="col-span-3">

                            <x-form.checkbox name="flotas_selected" left-label="{{ $flota->nombre }}"
                                id="flotas_selected" lg wire:model.live="flotas_selected" value="{{ $flota->id }}" />

                        </div>
                    @endforeach
                </div>

                @error('flotas')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        @endif
        <div class="col-span-12 sm:col-span-6">

            <x-form.select label="Selecciona una linea:" name="numero" wire:model.live="numero"
                placeholder="Selecciona una linea" option-description="option_description" :async-data="route('api.lineas.index')"
                option-label="numero" option-value="numero">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent='addLinea(`${search}`)' x-on:click="close" primary flat full>
                        <span x-html="`Registrar Linea <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>
        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="operador" name="operador" readonly placeholder="Claro" label="OPERADOR:" />
        </div>

        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="sim_card" name="sim_card" readonly placeholder="3189219220212"
                label="Sim Card:" />
            @error('sim_card_id')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="col-span-12 sm:col-span-6">

            <x-form.select label="IMEI GPS:" name="dispositivo_imei" wire:model.live="dispositivo_imei"
                placeholder="357073292893290" option-description="option_description" :async-data="route('api.dispositivos.index')"
                option-label="imei" option-value="imei">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent='registarImei(`${search}`)' x-on:click="close" primary flat full>
                        <span x-html="`Registrar Imei <b>${search}</b>`"></span>
                    </x-form.button>
                </x-slot>

            </x-form.select>

            @error('dispositivos_id')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>


        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model.live="modelo_gps" name="modelo_gps" readonly placeholder="FMB920"
                label="MODELO GPS:" />
        </div>

        <div class="col-span-12 sm:col-span-6">

            <label class="block text-sm font-medium mb-1" for="descripcion">DESCRIPCIÓN:</label>
            <div class="relative">
                <textarea wire:model.live="descripcion" class="form-input w-full pl-9" name="descripcion" id="descripcion"
                    rows="2" placeholder="Ingresar Breve Descripcíon"></textarea>
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

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
