<x-admin-layout ruta="vehiculos-reportes">

    @livewire('admin.vehiculos.reportes.index')

    {{-- Modales --}}
    @livewire('admin.vehiculos.reportes.save')
    @livewire('admin.vehiculos.reportes.edit')
    @livewire('admin.vehiculos.reportes.delete')
    @livewire('admin.vehiculos.reportes.recordatorio')
    @livewire('admin.vehiculos.reportes.show-contactos')
    @livewire('admin.vehiculos.reportes.estado-transmision')

</x-admin-layout>
