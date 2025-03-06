@extends('layouts.admin')

@section('contenido')

    @livewire('admin.facturacion.ventas.emitir', [
        'comprobante_slug' => Request::segment(3),
        'detalle_ids' => $detalle_ids,
        'cobro_id' => $cobro_id,
    ])

@stop

@push('modals')
    @livewire('admin.productos.create-modal')
    @livewire('admin.clientes.save')
@endpush



{{-- section de js --}}
@section('js')

@stop
