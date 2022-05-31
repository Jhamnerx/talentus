@extends('layouts.admin')
@section('ruta', 'almacen-productos')
@section('contenido')
<!-- Code block starts -->
<div
    class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add customer button -->
    <a href="{{route('admin.almacen.productos.index')}}">
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
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR PRODUCTO</h4>
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
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para crear un producto
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Rellena los campos obligatorios
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2 mr-6">


            {!! Form::open(['route' => 'admin.almacen.productos.store', 'autocomplete' => 'off', 'files' => 'true']) !!}
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-4">
                            {!! Form::hidden('empresa_id', session('empresa')) !!}
                            {!! Form::hidden('codigo', Str::random(10)) !!}
                            {!! Html::decode(Form::label('tipo','Tipo: <span class="text-rose-500">*</span>',
                            ['class'
                            => 'block text-sm font-medium mb-1'])) !!}
                            {!! Form::select('tipo', ["Producto" => 'Producto', "Servicio" => 'Servicio'], null,
                            ['class' => 'form-select']) !!}

                        </div>
                        <div class="col-span-12 sm:col-span-4">

                            {!! Html::decode(Form::label('nombre','Nombre: <span class="text-rose-500">*</span>',
                            ['class' => 'block text-sm font-medium mb-1'])) !!}

                            {!! Form::text('nombre', null, ['class' => 'form-input w-full valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer',
                            'required' =>'','placeholder' => 'Escribe el nombre']) !!}
                            @error('nombre')

                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{$message}}
                            </p>

                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-4">


                            {!! Html::decode(Form::label('categoria_id','Categoria: <span
                                class="text-rose-500">*</span>',
                            ['class'
                            => 'block text-sm font-medium mb-1'])) !!}
                            {!! Form::select('categoria_id', $categorias, null, ['class' => 'form-select']) !!}

                        </div>
                        <div class="col-span-12 sm:col-span-6">

                            {!! Form::label('precio', 'Precio:', ['class' => 'block text-sm font-medium mb-1']) !!}

                            <div class="relative">

                                {!! Form::number('precio', null, ['class' =>'form-input w-full pl-12', 'placeholder' =>
                                '$199.00']) !!}
                                <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                                    <span class="text-sm text-slate-400 font-medium px-3">S/</span>
                                </div>
                            </div>
                            @error('precio')

                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{$message}}
                            </p>

                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            {!! Form::label('stock', 'Stock:', ['class' => 'block text-sm font-medium mb-1']) !!}

                            {!! Form::number('stock', null, ['placeholder' => '10 Unidades','class' => 'form-input
                            w-full']) !!}

                            @error('stock')

                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{$message}}
                            </p>

                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-12 ">
                            {!! Form::label('descripcion', 'Descripción:', ['class' => 'block text-sm font-medium
                            mb-1']) !!}

                            {!! Form::textarea('descripcion', null, ['class' => 'form-input w-full','placeholder' =>
                            'Escribe una descripcion', 'rows' => 4]) !!}

                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label class="block text-sm font-medium text-gray-700"> Imagen </label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Subir Archivo</span>
                                            {{-- <input id="file-upload" name="file-upload" type="file" class="sr-only"
                                                accept="image/*"> --}}
                                            {!! Form::file('file', ['class' => 'sr-only', 'id' =>
                                            'file', 'accept' =>
                                            'image/*']) !!}
                                        </label>
                                        <p class="pl-1">o arrastra y suelta</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF Limite 10MB</p>
                                </div>
                                @error('file')

                                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>
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

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"
    integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $("#precio").maskMoney();
</script>
@endsection