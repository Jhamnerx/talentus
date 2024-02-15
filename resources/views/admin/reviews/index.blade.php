@extends('layouts.admin')

@section('ruta', 'administracion-reviews')



@section('contenido')

    <!-- Table -->
    @livewire('admin.reviews.index')

@stop



{{-- section de js --}}
@section('js')


@stop
