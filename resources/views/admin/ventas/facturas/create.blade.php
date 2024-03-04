@extends('layouts.admin')
@section('ruta', 'ventas-facturas')


@section('contenido')

    @livewire('admin.ventas.facturas.create')


@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
