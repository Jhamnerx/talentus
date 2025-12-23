<x-admin-layout>

    <!-- Table -->
    @livewire('admin.categorias.index')


</x-admin-layout>


@push('modals')
    @livewire('admin.categorias.create-modal')
    @livewire('admin.categorias.edit-modal')
    @livewire('admin.categorias.delete')
@endpush

{{-- section de js --}}
@section('js')



@stop
