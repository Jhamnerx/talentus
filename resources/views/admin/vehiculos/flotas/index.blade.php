@extends('layouts.admin')
@section('ruta', 'vehiculos-flotas')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.flotas.flotas-index')

@stop


@push('modals')
    @livewire('admin.vehiculos.flotas.save')
    @livewire('admin.vehiculos.flotas.edit')
@endpush
{{-- section de js --}}
@section('js')


@stop
