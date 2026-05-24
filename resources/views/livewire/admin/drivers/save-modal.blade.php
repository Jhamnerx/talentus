<div>
    <x-form.modal.card title="{{ $driver ? 'Editar Conductor' : 'Nuevo Conductor' }}" wire:model.live="modalOpen"
        width="xl" align="center">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form.select label="Tipo Documento *" wire:model.live="tipo_doc" :options="[['id' => '1', 'name' => 'DNI'], ['id' => '4', 'name' => 'Carnet de Extranjería']]" option-label="name"
                    option-value="id" :clearable="false" />
                <div>
                    <x-form.input label="N° Documento *" wire:model.live="numero_doc" placeholder="12345678">
                        <x-slot name="append">
                            <div class="flex items-center mr-1">
                                <x-form.button wire:click="searchDni" spinner="searchDni" icon="magnifying-glass" xs
                                    primary :disabled="$tipo_doc !== '1'" title="Buscar en RENIEC" />
                            </div>
                        </x-slot>
                    </x-form.input>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-form.input label="Nombres *" wire:model.live="name" placeholder="ROBERTO" />
                <x-form.input label="Apellidos" wire:model.live="last_name" placeholder="RODRIGUEZ VALENCIA" />
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-form.input label="Licencia de Conducir" wire:model.live="licencia" placeholder="A-IIB-12345" />
                <x-form.input label="Teléfono" wire:model.live="telephone" placeholder="987654321" />
            </div>
            <div class="flex items-center gap-6">
                <x-form.toggle wire:model.live="is_default" label="Predeterminado" md />
                <x-form.toggle wire:model.live="is_active" label="Activo" md />
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
