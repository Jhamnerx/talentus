<x-form.modal.card title="EDITAR VEHICULO" blur wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-6 sm:col-span-6">
            <x-form.input wire:model.change="placa" label="Placa Unidad:" placeholder="ABC-780" />
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
            <x-form.select autocomplete='off' label="Selecciona un cliente:" id="clientes_id"
                wire:model.live="clientes_id" placeholder="Selecciona un cliente" option-description="numero_documento"
                :async-data="route('api.clientes.index')" option-label="razon_social" option-value="id">

                <x-slot name="beforeOptions" class="p-2 flex justify-center">
                    <x-form.button wire:click.prevent="OpenModalCliente(`${search}`)" primary flat full>
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
            <x-form.select autocomplete='off' label="Selecciona una linea:" id="numero" name="numero"
                wire:model.live="numero" placeholder="945678000" option-description="operador" :async-data="route('api.lineas.index')"
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
        </div> <!-- Sección para agregar dispositivos -->
        <div class="col-span-12 sm:col-span-12">
            <h4 class="font-semibold text-lg mb-3">Dispositivos GPS</h4>
            <p class="text-sm text-gray-600 mb-3">Seleccione al menos un dispositivo y marque uno como principal.</p>
            <p class="text-sm text-red-500 mb-3">
                <i class="fas fa-info-circle mr-1"></i>
                Los dispositivos que ya estén asignados a otros vehículos no podrán ser seleccionados.
            </p>
            <div class="col-span-12 sm:col-span-6 mb-4">
                <x-form.select autocomplete='off' label="Seleccionar dispositivo GPS:" id="dispositivo_imei"
                    name="dispositivo_imei" wire:model.live="dispositivo_imei" placeholder="357073292893290"
                    option-description="option_description" :async-data="route('api.dispositivos.index')" option-label="imei" option-value="imei">

                    <x-slot name="beforeOptions" class="p-2 flex justify-center">
                        <x-form.button wire:click.prevent='registarImei(`${search}`)' x-on:click="close" primary flat
                            full>
                            <span x-html="`Registrar Imei <b>${search}</b>`"></span>
                        </x-form.button>
                    </x-slot>
                </x-form.select>
                <!-- Removido el mensaje de error ya que el campo no es obligatorio -->
            </div>

            <!-- Lista de dispositivos seleccionados -->
            <div class="col-span-12">
                @if (count($dispositivos) > 0)
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">IMEI</th>
                                <th scope="col" class="px-6 py-3">Modelo</th>
                                <th scope="col" class="px-6 py-3">Principal</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dispositivos as $index => $dispositivo)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">{{ $dispositivo['imei'] }}</td>
                                    <td class="px-6 py-4">{{ $dispositivo['modelo'] }}</td>
                                    <td class="px-6 py-4">
                                        <input type="radio" name="dispositivo_principal"
                                            wire:click="marcarComoPrincipal({{ $index }})"
                                            {{ $dispositivo_principal === $index ? 'checked' : '' }}>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="button" wire:click="quitarDispositivo({{ $index }})"
                                            class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center p-4 bg-gray-100 rounded">
                        <p>No se han seleccionado dispositivos</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-span-12 sm:col-span-6">
            <label class="block text-sm font-medium mb-1" for="descripcion">DESCRIPCIÓN:</label>
            <div class="relative">
                <textarea id="descripcion" rows="3" wire:model="descripcion" class="form-input w-full px-2 py-1"></textarea>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-form.button flat label="Cancelar" wire:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" spinner="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
