@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')


@section('contenido')

    @livewire('admin.ventas.presupuestos.create')

@stop


@push('modals')
    @livewire('admin.clientes.save')
@endpush
