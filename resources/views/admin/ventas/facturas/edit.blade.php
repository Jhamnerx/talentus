@extends('layouts.admin')
@section('ruta', 'ventas-facturas')


@section('contenido')

    @livewire('admin.ventas.facturas.edit', ['factura' => $factura])

@stop

@push('modals')
    @livewire('admin.clientes.save')
@endpush
