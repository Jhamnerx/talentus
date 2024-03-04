@extends('layouts.admin')

@section('contenido')


    @livewire('admin.facturacion.nota.emitir', ['comprobante_slug' => Request::segment(3)])

@stop


@push('modals')
    @livewire('admin.facturacion.utiles.iframe-modal')
@endpush


{{-- section de js --}}
@section('js')

@stop
