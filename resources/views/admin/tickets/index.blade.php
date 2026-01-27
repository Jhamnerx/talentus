<x-admin-layout>

    @livewire('admin.tickets.index')

    @livewire('admin.tickets.create', key('create-ticket'))
    @livewire('admin.tickets.edit', key('edit-ticket'))

    @push('modals')
        @livewire('admin.tickets.delete', key('delete-ticket'))
    @endpush

</x-admin-layout>
