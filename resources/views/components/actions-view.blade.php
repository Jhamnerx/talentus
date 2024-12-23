<x-form.dropdown>
    @if (in_array('edit', $actions))
        <x-dropdown.item icon="pencil" label="Editar" wire:click.prevent="openModalEdit({{ $row->id }})" />
        
    @endif

    @if (in_array('delete', $actions))
        <x-dropdown.item icon="trash" label="Eliminar" wire:click.prevent="openModalDelete({{ $row->id }})" />
    @endif   

    @if (in_array('show-sim-card-cambios', $actions))
        <x-dropdown.item icon="eye" label="ver Cambios"  wire:click.prevent="openModalCambios({{ $row->id }})" />
    @endif    
    @if (in_array('unasign', $actions))
        <x-dropdown.item icon="trash" label="Eliminar numero"  wire:click.prevent="openModalUnAsign({{ $row->id }})" />
    @endif

</x-form.dropdown>