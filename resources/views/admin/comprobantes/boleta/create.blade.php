@extends('layouts.admin')

@section('contenido')

    @livewire('admin.facturacion.ventas.emitir', ['comprobante_slug' => Request::segment(3)])

@stop

@push('modals')
    @livewire('admin.productos.create-modal')
    @livewire('admin.clientes.save')
@endpush



{{-- section de js --}}
@section('js')

@stop
