@extends('layouts.admin')
@section('ruta', 'almacen-productos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.productos.productos-index')

@stop

@push('modals')
    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.edit-modal')
    @livewire('admin.productos.delete')
@endpush

@section('js')
@stop
