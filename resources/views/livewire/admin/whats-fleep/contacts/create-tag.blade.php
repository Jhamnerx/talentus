<div>
    <x-form.modal.card title="Crear Grupo" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="name" label="Nombre del Grupo" placeholder="Ej: Clientes VIP"
                hint="Nombre para identificar el grupo de contactos" />
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3">
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    💡 Los grupos te ayudan a organizar tus contactos. Puedes usarlos para segmentar tus campañas de
                    mensajes.
                </p>
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Crear Grupo" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
