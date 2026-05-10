<div>
    <x-form.modal.card title="Editar Dispositivo" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="body" label="Nombre del dispositivo" />
            <x-form.textarea wire:model="webhook" label="Webhook URL (opcional)" rows="2" />
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Guardar cambios" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
