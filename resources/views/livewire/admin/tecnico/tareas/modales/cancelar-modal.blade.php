<x-form.modal.card title="CANCELAR TAREA" wire:model="openModalDelete" blur max-width="lg">
    <div class="flex items-start space-x-4">
        <!-- Icon -->
        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-rose-100">
            <svg class="w-4 h-4 shrink-0 fill-current text-rose-500" viewBox="0 0 16 16">
                <path
                    d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
            </svg>
        </div>
        <!-- Content -->
        <div class="flex-1">
            <p class="text-sm text-slate-600">¿Estás seguro de CANCELAR esta tarea?</p>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-2">
            <x-form.button flat label="Cancelar" wire:click="$set('openModalDelete', false)" />
            <x-form.button negative label="Sí, Cancelar" wire:click="cancel" />
        </div>
    </x-slot>
</x-form.modal.card>
