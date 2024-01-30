@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')


@section('contenido')

    @livewire('admin.ventas.presupuestos.create')

@stop


@push('modals')
    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.modal-add-producto')
@endpush
