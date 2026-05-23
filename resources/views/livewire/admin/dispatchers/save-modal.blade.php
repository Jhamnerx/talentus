<div>
    <x-form.modal.card title="{{ $dispatcher ? 'Editar Transportista' : 'Nuevo Transportista' }}"
        wire:model.live="modalOpen" width="xl" align="center">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form.select label="Tipo Documento *" wire:model.live="tipo_doc" :options="[['id' => '6', 'name' => 'RUC'], ['id' => '1', 'name' => 'DNI']]" option-label="name"
                    option-value="id" :clearable="false" />
                <x-form.input label="N° Documento *" wire:model.live="numero_doc" placeholder="20123456789" />
            </div>
            <x-form.input label="Razón Social *" wire:model.live="razon_social" placeholder="Transportes SAC" />
            <x-form.input label="Dirección" wire:model.live="address" placeholder="Av. Principal 123" />
            <x-form.input label="N° MTC (Habilitación)" wire:model.live="numero_mtc" placeholder="MTC-12345" />
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
