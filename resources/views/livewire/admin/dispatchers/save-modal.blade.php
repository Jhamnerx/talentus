<div>
    <x-form.modal.card title="{{ $dispatcher ? 'Editar Transportista' : 'Nuevo Transportista' }}"
        wire:model.live="modalOpen" width="3xl" align="center">
        <div class="grid grid-cols-2 gap-x-4 gap-y-4">
            {{-- Fila 1: Tipo Doc | Número --}}
            <x-form.select label="Tipo Doc. Identidad *" wire:model.live="tipo_doc" :options="[['id' => '6', 'name' => 'RUC'], ['id' => '1', 'name' => 'DNI']]" option-label="name"
                option-value="id" :clearable="false" />
            <div>
                <x-form.input label="Número *" wire:model.live="numero_doc"
                    placeholder="{{ $tipo_doc === '1' ? '12345678' : '20123456789' }}"
                    wire:keydown.enter="buscarDocumento">
                    <x-slot name="append">
                        <x-form.button class="h-full px-3" label="SUNAT" icon="magnifying-glass" rounded="rounded-r-md"
                            primary wire:click="buscarDocumento" wire:loading.attr="disabled"
                            spinner="buscarDocumento" />
                    </x-slot>
                </x-form.input>
                @if ($errorConsulta)
                    <p class="mt-1 text-sm text-red-600">{{ $errorConsulta }}</p>
                @endif
            </div>

            {{-- Fila 2: Nombre | Dirección fiscal --}}
            <x-form.input label="Nombre *" wire:model.live="razon_social" placeholder="Transportes SAC" />
            <x-form.input label="Dirección fiscal" wire:model.live="address" placeholder="Av. Principal 123" />

            {{-- Fila 3: MTC | Toggle --}}
            <x-form.input label="MTC" wire:model.live="numero_mtc" placeholder="MTC-12345" />
            <div class="flex items-end pb-1">
                <x-form.toggle wire:model.live="is_active" label="Predeterminado" md />
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="$set('modalOpen', false)" flat />
                <x-form.button label="Guardar" wire:click="save" primary spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
