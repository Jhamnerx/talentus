@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')



    @livewire('admin.vehiculos.show', ['vehiculo' => $vehiculo])


@stop
