@extends('layouts.app')

@section('contenido')


    @livewire('admin.ventas.emitir', ['comprobante_slug' => Request::segment(2)])

@stop




{{-- section de js --}}
@section('js')

@stop
