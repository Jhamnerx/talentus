<x-form.modal.card title="Editar Usuario" wire:model.live="showModal" align="center" width="xl">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-6">

            <x-form.input id="name-e" wire:model.change="name" label="Nombre (*):" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.input id="email-e" wire:model.live="email" type="email" label="Correo Electronico (*):" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.password label="Contraseña 🙈" wire:model.live="password" id="password-e"
                placeholder="Ingresa tu contraseña (*):" />
        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.password label="Confirma tu Contraseña" wire:model.live="password_confirmation"
                id="password_confirmation-e" placeholder="Confirma tu contraseña (*):" />
        </div>

        <div class="col-span-12 md:col-span-6">

            <x-form.select label="Rol (*):" wire:model.live="roles_id" placeholder="Selecciona" :options="$roles"
                option-label="name" option-value="id" :searchable="false" multiselect />

        </div>

    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex gap-2">
                <x-form.button flat label="Cancelar" wire:click="closeModal" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" spinner="save" />
            </div>
        </div>
    </x-slot>

</x-form.modal.card>
