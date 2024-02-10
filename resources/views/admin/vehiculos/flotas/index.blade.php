@extends('layouts.admin')
@section('ruta', 'vehiculos-flotas')
@section('contenido')

    <!-- Table -->
    @livewire('admin.vehiculos.flotas.flotas-index')

@stop

{{-- section de js --}}
@section('js')


@stop
