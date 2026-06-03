<x-form.modal.card title="REGISTRAR RAPIDO DE VEHICULO" blur wire:model.live="modalOpen" align="center" persistent>

    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 sm:col-span-12">
            <x-form.input wire:model.live.change="placa" label="Placa Unidad:" placeholder="ABC-780" class="uppercase"
                x-on:input="$event.target.value = $event.target.value.toUpperCase()">
                <x-slot name="append">
                    <x-form.button class="h-full" icon="magnifying-glass" rounded="rounded-r-md" primary flat
                        wire:click="buscarPlaca" wire:loading.attr="disabled" spinner="buscarPlaca" />
                </x-slot>
            </x-form.input>
            @if ($errorConsultaPlaca)
                <p class="mt-1 text-sm text-red-600">{{ $errorConsultaPlaca }}</p>
            @endif
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
                option-label="razon_social" option-value="id" />
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

        <div class="col-span-12">
            <x-form.textarea wire:model="descripcion" label="Descripción:" rows="3"
                placeholder="Observaciones adicionales del vehículo..." />
        </div>

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
