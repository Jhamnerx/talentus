@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')


@section('contenido')

    @livewire('admin.ventas.presupuestos.edit', ['presupuesto' => $presupuesto])

@stop


@push('modals')
    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.modal-add-producto')
@endpush
