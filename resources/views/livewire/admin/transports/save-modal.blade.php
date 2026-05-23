<x-form.modal.card title="{{ $transport ? 'Editar Vehículo' : 'Nuevo Vehículo' }}" wire:model.live="modalOpen"
    width="lg" align="center">
    <div class="space-y-4">
        <x-form.input label="Placa *" wire:model.live="placa" placeholder="ABC-123" />
        <div class="grid grid-cols-2 gap-4">
            <x-form.input label="Marca" wire:model.live="marca" placeholder="Volvo" />
            <x-form.input label="Modelo" wire:model.live="modelo" placeholder="FH 460" />
        </div>
        <x-form.input label="Certificado de habilitación vehicular (TUC)" wire:model.live="tuc"
            placeholder="TUC-12345" />
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
