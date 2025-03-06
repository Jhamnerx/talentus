@extends('layouts.admin')
@section('ruta', 'ventas-recibos')


@section('contenido')

    @livewire('admin.ventas.recibos.create', [
        'detalle_ids' => $detalle_ids,
        'cobro_id' => $cobro_id,
    ])


@stop

@push('modals')
    @livewire('admin.clientes.save')
    @livewire('admin.productos.create-modal')
@endpush
