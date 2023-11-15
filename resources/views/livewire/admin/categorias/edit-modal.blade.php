<x-form.modal.card title="Editar Categoria" blur wire:model.live="modalEdit" align="center">

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 sm:col-span-6">

            <x-form.input wire:model="nombre" label="Nombre:" placeholder="Escribe el nombre" />

        </div>
        <div class="col-span-12 sm:col-span-6">

            <x-form.textarea wire:model="descripcion" label="Descripcion:" placeholder="Escribe la descripción" />

        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
