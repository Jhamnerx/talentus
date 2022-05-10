@extends('layouts.admin')
@section('ruta', 'almacen-categorias')
@section('contenido')
<!-- Code block starts -->
<div
    class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add customer button -->
    <a href="{{route('admin.almacen.categorias.index')}}">
        <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back w-5 h-5"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
            </svg>
            <span class="hidden xs:block ml-2">Atras</span>
        </button>
    </a>
    <div>
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">EDITAR CATEGORIA</h4>
        <ul aria-label="current Status"
            class="flex flex-col md:flex-row items-start md:items-center text-gray-600 dark:text-gray-400 text-sm mt-3">
            <li class="flex items-center mr-4">
                <div class="mr-1">
                    <img class="dark:hidden"
                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1.svg"
                        alt="Active">
                    <img class="dark:block hidden"
                        src="https://tuk-cdn.s3.amazonaws.com/can-uploader/simple_with_sub_text_and_border-svg1dark.svg"
                        alt="Active">
                </div>
                <span>Active</span>
            </li>

        </ul>
    </div>
</div>
<!-- Code block ends -->


<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1 ml-4">
            <div class="px-6 sm:px-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para editar una categoria
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    No dejes vacios los campos obligatorios
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">

            {!! Form::model($categoria, ['route' => ['admin.almacen.categorias.update', $categoria], 'method' => 'put'])
            !!}
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-4">
                            {!! Form::hidden('empresa_id', session('empresa')) !!}
                            {{-- Nombre Categoria --}}

                            {!! Html::decode(Form::label('nombre','Nombre <span class="text-rose-500">*</span>',
                            ['class'
                            => 'block text-sm font-medium mb-1'])) !!}

                            {!! Form::text('nombre', null, ['class' => 'form-input w-full valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer',
                            'placeholder' => 'Escribe el nombre...']) !!}

                            @error('nombre')

                            <small class="text-danger">{{$message}}</small>

                            @enderror

                        </div>
                        <div class="col-span-6 sm:col-span-4">

                            {{-- Descripcion Categoria --}}
                            {!! Form::label('descripcion', 'Descripción', ['class'=> 'block text-sm font-medium mb-1'])
                            !!}

                            {!! Form::text('descripcion', null, ['class' => 'form-input w-full', 'placeholder' =>
                            'Escribe la descripción...']) !!}

                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    {!! Form::submit('GUARDAR', ['class'=>'btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none
                    focus:ring-2 focus:ring-offset-2
                    focus:ring-emerald-600 text-white']) !!}

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection