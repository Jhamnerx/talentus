<x-form.dropdown>
    @if (in_array('edit', $actions))

        @can('editar-'.$model)
            <x-dropdown.item icon="pencil" label="Editar" wire:click.prevent="openModalEdit({{ $row->id }})" />
        @endcan
    
    @endif

    @if (in_array('delete', $actions))

        @can('eliminar-'.$model)
            <x-dropdown.item icon="trash" label="Eliminar" wire:click.prevent="openModalDelete({{ $row->id }})" />
        @endcan

    @endif

</x-form.dropdown>