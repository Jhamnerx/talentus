@extends('layouts.admin')
@section('ruta', 'administracion-usuarios')
@section('contenido')
<!-- Code block starts -->
<div
    class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add customer button -->
    <a href="{{ route('admin.users.index') }}">
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
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">CREAR USUARIO</h4>
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
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para editar un usuario
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Rellena los campos obligatorios
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2 mr-6">


            {!! Form::model($user, ['route' => ['admin.users.update', $user], 'autocomplete' => 'off', 'method' =>
            'PUT']) !!}
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-12 gap-6">

                        <div class="col-span-12 sm:col-span-6">

                            {!! Html::decode(
                            Form::label('name', 'Nombre: <span class="text-rose-500">*</span>', ['class' => 'block
                            text-sm font-medium mb-1']),
                            ) !!}

                            {!! Form::text('name', null, [
                            'class' => 'form-input w-full valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer',
                            'required' => '',
                            'placeholder' => 'Escribe el nombre',
                            ]) !!}
                            @error('name')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-6">

                            {!! Html::decode(
                            Form::label('email', 'Email: <span class="text-rose-500">*</span>', ['class' => 'block
                            text-sm font-medium mb-1']),
                            ) !!}

                            {!! Form::text('email', null, [
                            'class' => 'form-input w-full valid:border-emerald-300
                            required:border-rose-300 invalid:border-rose-300 peer',
                            'required' => '',
                            'placeholder' => 'Escribe el email',
                            ]) !!}
                            @error('email')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-12">

                            {!! Html::decode(
                            Form::label('roles', 'Rol: <span class="text-rose-500">*</span>', ['class' => 'block text-sm
                            font-medium mb-1']),
                            ) !!}

                            {!! Form::select('roles[]', $roles,
                            $user->getRoleNames() ? $user->getRoleNames()[0] : NULL, ['class' => 'form-input
                            w-2/4']) !!}

                            @error('roles')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            {!! Form::label('password', 'Contraseña:', [
                            'class' => 'block text-sm font-medium
                            mb-1',
                            ]) !!}

                            {!! Form::password('password', ['class' => 'form-input w-full',
                            'placeholder' => 'Escribe una nueva contraseña']) !!}
                            @error('password')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            {!! Form::label('password_confirmation', 'Confirmar Contraseña:', [
                            'class' => 'block text-sm
                            font-medium
                            mb-1',
                            ]) !!}

                            {!! Form::password('password_confirmation', [
                            'class' => 'form-input w-full',
                            'placeholder' => 'una nueva contraseña',
                            ]) !!}
                            @error('password_confirmation')
                            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="col-span-12 sm:col-span-4">
                            <label for="tipo_documento" class="block text-sm font-medium mb-1">Tipo Documento:</label>

                            <select name="tipo_documento" id="tipo_documento" class="form-select w-full">
                                <option value="DNI" @selected(old('tipo_documento')=='DNI' || $user->tipo_documento ==
                                    'DNI' )>DNI</option>
                                <option value="RUC" @selected(old('tipo_documento')=='RUC' || $user->tipo_documento ==
                                    'RUC' )>RUC</option>
                            </select>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <label for="numero_documento" class="block text-sm font-medium mb-1">Número
                                Documento:</label>

                            <input type="text"
                                value="{{old('numero_documento') ? old('numero_documento') : $user->numero_documento}}"
                                name="numero_documento" class="form-input w-full" placeholder="52416324">
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <label for="telefonos" class="block text-sm font-medium mb-1">Celular:</label>

                            <input type="text" value="{{old('telefonos') ? old('telefonos') : $user->telefonos}}"
                                name="telefonos" class="form-input w-full" placeholder="987654321" maxlength="9">
                        </div>

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    {!! Form::submit('GUARDAR', [
                    'class' => 'btn bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 focus:outline-none
                    focus:ring-2 focus:ring-offset-2
                    focus:ring-emerald-600 text-white',
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
