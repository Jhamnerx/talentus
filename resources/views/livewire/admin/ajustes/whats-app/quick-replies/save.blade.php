<div>
    <x-form.modal.card title="RESPUESTA RÁPIDA" max-width="lg" wire:model.live="showModal" align="center">
        <form autocomplete="off">
            <div class="px-5 py-4 grid grid-cols-12 gap-4">

                <div class="col-span-12 sm:col-span-5">
                    <label class="block text-sm font-medium mb-1">Atajo</label>
                    <input type="text" wire:model="shortcut" class="form-input w-full" placeholder="/saludo" />
                    @error('shortcut')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12 sm:col-span-7">
                    <label class="block text-sm font-medium mb-1">Título</label>
                    <input type="text" wire:model="title" class="form-input w-full" placeholder="Saludo de bienvenida" />
                    @error('title')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12">
                    <label class="block text-sm font-medium mb-1">Mensaje</label>
                    <textarea wire:model="body" rows="5" class="form-textarea w-full"
                        placeholder="Escribe el mensaje..."></textarea>
                    @error('body')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-12 flex items-center gap-3">
                    <label class="block text-sm font-medium">Activa</label>
                    <input type="checkbox" wire:model="active" class="form-checkbox" />
                    @error('active')
                        <p class="mt-1 text-pink-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </form>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" x-on:click.prevent="$wire.set('showModal', false)" />
                <x-form.button primary label="Guardar" wire:click.prevent="save" spinner="save" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>
