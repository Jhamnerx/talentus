<x-form.modal.card title="Editar Usuario" wire:model.live="showModal" align="center" width="2xl">
    <div class="grid grid-cols-12 gap-6 p-4 bg-white rounded-lg shadow-md">
        <div class="col-span-12 sm:col-span-6">
            <x-form.input id="name-e" wire:model.change="name" label="Nombre (*):" class="mb-2" />
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.input id="email-e" wire:model.live="email" type="email" label="Correo Electrónico (*):"
                class="mb-2" autocomplete="off" autocorrect="off" spellcheck="false" />
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.password label="Contraseña 🙈" wire:model.live="password" id="password-e"
                placeholder="Ingresa tu contraseña (*):" class="mb-2" />
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-form.password label="Confirma tu Contraseña" wire:model.live="password_confirmation"
                id="password_confirmation-e" placeholder="Confirma tu contraseña (*):" class="mb-2" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Rol (*):" wire:model.live="roles_id" placeholder="Selecciona" :options="$roles"
                option-label="name" option-value="id" :searchable="false" multiselect class="mb-2" />
        </div>
        <div class="col-span-12 md:col-span-6">
            <x-form.select label="Documento:" autocomplete='off' name="document_id" wire:model.live="document_id"
                id="document_id-e" :async-data="route('api.tipo.comprobantes.index')" option-label="descripcion" option-value="codigo" class="mb-2" />
        </div>
        @if ($series && $series->count())
            <div class="col-span-12 md:col-span-6">
                <x-form.select placeholder="Selecciona un documento" label="Serie:" wire:model.live="series_id"
                    placeholder="Selecciona" :options="$series" option-label="serie" option-value="id" :searchable="false"
                    class="mb-2" />
            </div>
        @endif
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4 p-4 bg-gray-50 rounded-b-lg">
            <div class="flex gap-2">
                <x-form.button flat label="Cancelar" wire:click="closeModal" class="px-6 py-2" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" spinner="save" class="px-6 py-2" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
