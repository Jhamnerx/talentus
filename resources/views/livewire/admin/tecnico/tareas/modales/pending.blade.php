<div>
    <x-form.modal.card title="TAREAS PENDIENTES" max-width="5xl" wire:model.live="openModal">

        <x-admin.tecnico.tareas.modales.table-pending :tareas="$tareas">
        </x-admin.tecnico.tareas.modales.table-pending>

        <div class="mt-8 w-full">
            {{ $tareas->links() }}

        </div>


        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-form.button flat label="Cerrar" wire:click.prevent="closeModal" />
            </div>
        </x-slot>
    </x-form.modal.card>
</div>

@once
    @push('scripts')
    @endpush
@endonce
