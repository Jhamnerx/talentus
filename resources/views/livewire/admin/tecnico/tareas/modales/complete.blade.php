<div>
    <x-form.modal.card title="TAREAS COMPLETADAS" max-width="5xl" wire:model.live="openModal">

        <x-admin.tecnico.tareas.modales.table-complete :tareas="$tareas">
        </x-admin.tecnico.tareas.modales.table-complete>

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
        <script>
            $(document).ready(function() {


            })
        </script>
    @endpush
@endonce
