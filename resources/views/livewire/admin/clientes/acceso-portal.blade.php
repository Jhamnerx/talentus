<x-form.modal.card title="ACCESO AL PORTAL" max-width="lg" wire:model.live="modal" align="center">

    @if ($cliente)
        <div class="mb-4 rounded-lg bg-gray-50 dark:bg-gray-900/30 p-3">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Cliente:
                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $cliente->razon_social }}</span>
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">RUC/DNI: {{ $cliente->numero_documento }}</p>

            @if ($clienteUserId)
                <p class="mt-2 text-xs text-gray-600 dark:text-gray-300">
                    Acceso existente — estado actual:
                    <span class="font-semibold">{{ ucfirst($estadoActual) }}</span>.
                    Al guardar se restablece la contraseña y queda <span class="font-semibold text-emerald-600">activo</span>.
                </p>
            @else
                <p class="mt-2 text-xs text-emerald-600">
                    Se creará el acceso (titular) y quedará activo de inmediato.
                </p>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12">
            <x-form.input label="Nombre del usuario:" placeholder="Nombre del titular" wire:model="name" />
        </div>

        <div class="col-span-12">
            <x-form.input type="email" label="Correo (login):" placeholder="correo@empresa.com"
                wire:model="email" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.input type="password" label="Contraseña:" placeholder="Mínimo 8 caracteres"
                wire:model="password" />
        </div>

        <div class="col-span-12 sm:col-span-6">
            <x-form.input type="password" label="Confirmar contraseña:" placeholder="Repite la contraseña"
                wire:model="password_confirmation" />
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar y activar" wire:click="save" spinner="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
