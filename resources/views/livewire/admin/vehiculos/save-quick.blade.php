<x-form.modal.card title="REGISTRAR RAPIDO DE VEHICULO" blur wire:model.live="modalOpen" align="center">

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
                option-label="razon_social" option-value="id" hide-empty-message />
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

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
