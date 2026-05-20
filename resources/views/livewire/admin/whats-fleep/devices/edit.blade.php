<div>
    <x-form.modal.card title="Editar Dispositivo" blur wire:model.live="showModal" align="center">
        <div class="space-y-4">
            <x-form.input wire:model="body" label="Nombre del dispositivo" />
            <x-form.textarea wire:model="webhook" label="Webhook URL (opcional)" rows="2" />
            <div
                class="flex items-start gap-3 p-3 rounded-lg bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50">
                <x-form.toggle wire:model.live="interno" id="interno-edit" />
                <div>
                    <label for="interno-edit"
                        class="block text-sm font-medium text-amber-800 dark:text-amber-300 cursor-pointer">Dispositivo
                        del sistema</label>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-0.5">Usar este número para notificaciones
                        internas (tickets, órdenes de trabajo, etc.). Solo puede haber uno activo.</p>
                </div>
            </div>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <x-form.button flat label="Cancelar" x-on:click="$wire.showModal = false" />
                <x-form.button wire:click="save" spinner="save" primary label="Guardar cambios" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
