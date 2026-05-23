<div>
    <x-form.modal.card title="{{ $driver ? 'Editar Conductor' : 'Nuevo Conductor' }}" wire:model.live="modalOpen"
        width="xl" align="center">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form.select label="Tipo Documento *" wire:model.live="tipo_doc" :options="[['id' => '1', 'name' => 'DNI'], ['id' => '4', 'name' => 'Carnet de Extranjería']]" option-label="name"
                    option-value="id" :clearable="false" />
                <x-form.input label="N° Documento *" wire:model.live="numero_doc" placeholder="12345678" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-form.input label="Nombres *" wire:model.live="nombres" placeholder="Nombres" />
                <x-form.input label="Apellidos" wire:model.live="apellidos" placeholder="Apellidos" />
            </div>
            <x-form.input label="Licencia de Conducir" wire:model.live="licencia" placeholder="A-IIB-12345" />
            <x-form.toggle wire:model.live="is_active" label="Activo" md />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-form.button label="Cancelar" wire:click="$set('modalOpen', false)" flat />
                <x-form.button label="Guardar" wire:click="save" primary spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
