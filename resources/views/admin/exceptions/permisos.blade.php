@extends('layouts.admin')

@section('ruta', 'dashboard-inicio')



@section('contenido')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div class="max-w-2xl m-auto mt-16">

        <div class="text-center px-4">
            <div class="inline-flex mb-8">
                <img src="{{asset('images/no-perm.jpg')}}" alt=" 404 illustration" />
            </div>
            <div class="mb-6">Hmm...No tienes permisos para ver esto!</div>
            <a href="{{route('admin.home')}}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Ir al inicio</a>
        </div>

    </div>

</div>
@stop



{{-- section de js --}}
@section('js')



@stop
