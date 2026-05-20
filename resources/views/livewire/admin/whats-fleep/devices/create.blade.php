<div>
    <x-form.modal.card title="Nuevo Dispositivo WhatsApp" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="body" label="Nombre del dispositivo" placeholder="Ej: Soporte-01" />
            <x-form.textarea wire:model="webhook" label="Webhook URL (opcional)" placeholder="https://..."
                rows="2" />
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Crear dispositivo" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
