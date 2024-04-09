@extends('layouts.admin')

@section('contenido')


    @livewire('admin.facturacion.ventas.emitir', ['comprobante_slug' => Request::segment(3)])

@stop


@push('modals')
    @livewire('admin.productos.create-modal')
    @livewire('admin.productos.modal-add-producto')
    @livewire('admin.clientes.save')
    @livewire('admin.facturacion.ventas.modal-detraccion')
@endpush


{{-- section de js --}}
@section('js')

@stop
