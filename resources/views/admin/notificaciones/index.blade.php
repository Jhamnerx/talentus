@extends('layouts.admin')

@section('ruta', 'admin-notificaciones')



@section('contenido')

    <!-- Table -->
    {{ $user->notifications }}

@stop



{{-- section de js --}}
@section('js')

@stop
