<x-form.dropdown>
    @if (in_array('edit', $actions))
        <x-dropdown.item icon="pencil" label="Editar" wire:click.prevent="openModalEdit({{ $row->id }})" />
        
    @endif

    @if (in_array('delete', $actions))
        <x-dropdown.item icon="trash" label="Eliminar" wire:click.prevent="openModalDelete({{ $row->id }})" />
    @endif

</x-form.dropdown>