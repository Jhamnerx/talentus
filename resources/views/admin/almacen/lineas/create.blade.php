@extends('layouts.admin')
@section('ruta', 'almacen-lineas')
@section('contenido')
<!-- Code block starts -->
<div
    class="my-6 lg:my-12 container px-6 mx-auto flex flex-col md:flex-row items-start md:items-center justify-between pb-4 border-b border-gray-300">
    <!-- Add  button -->
    <a href="{{route('admin.almacen.lineas.index')}}">
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
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">AÑADIR LINEAS</h4>
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
    <div class="md:grid md:grid-cols-12 md:gap-6">
        <div class="md:col-span-2 ml-2">
            <div class="px-6 sm:px-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Formulario para crear una linea
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Rellena los campos obligatorios
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-10 mr-6">


            @livewire('admin.lineas.save', key($user->id))

            {{-- <div class="px-4 py-5 bg-white sm:p-6 shadow overflow-hidden sm:rounded-md">
                <div class="col-span-12 px-4 py-3 text-right sm:px-6">
                    <div class="font-semibold text-right">AÑADIR ITEM</div>
                    <a @click="addNewField()" class="btn bg-indigo-500 hover:bg-indigo-600 text-white float-right">
                        <svg class="w-4 h-4 fill-current opacity-50 shrink-0 text-white" viewBox="0 0 16 16">
                            <path
                                d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>

                    </a>
                </div>
                {!! Form::open(['route' => 'admin.almacen.lineas.store', 'autocomplete' => 'off']) !!}
                {!! Form::hidden('empresa_id', session('empresa')) !!}

                <div class="px-4 py-5 bg-white sm:p-6">


                    <template x-for="(field, index) in fields" :key="index">
                        <div class="grid grid-cols-12 gap-2 mb-4 items-center relative">

                            <div class="col-span-4 sm:col-span-1">
                                <span x-text="index + 1"></span>
                            </div>

                            <div class="col-span-4 sm:col-span-3">
                                {!! Form::label('sim_card', 'Sim Card:', ['class' => 'block text-sm font-medium mb-1'])
                                !!}
                                {!! Form::text('sim_card[]', null, ['class' => 'form-input w-full', 'x-model' =>
                                'field.sim_card', 'placeholder' => 'Escribe el sim card...']) !!}

                                @error('sim_card[]')

                                <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>

                            <div class="col-span-4 sm:col-span-3">
                                {!! Form::label('numero', 'Numero:', ['class' => 'block text-sm font-medium mb-1'])
                                !!}
                                {!! Form::text('numero[]', null, ['class' => 'form-input w-full', 'x-model' =>
                                'field.numero', 'placeholder' => 'Escribe el numero...']) !!}

                                @error('numero[]')

                                <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>
                            <div class="col-span-4 sm:col-span-3">
                                {!! Form::label('operador', 'Operador:', ['class' => 'block text-sm font-medium mb-1'])
                                !!}
                                {!! Form::text('operador[]', null, ['class' => 'form-input w-full', 'x-model' =>
                                'field.operador', 'placeholder' => 'Escribe el operador...']) !!}

                                @error('operador[]')

                                <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
                                    {{$message}}
                                </p>

                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-2">
                                <button type="button" @click="removeField(index)"
                                    class="text-rose-500 hover:text-rose-600 rounded-full">
                                    <span class="sr-only">Eliminar</span>
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                        <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                        <path
                                            d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                    </svg>
                                </button>

                                <button type="button" class="btn btn-primary" @click="saveForm(index)">Save</button>
                            </div>
                        </div>
                    </template>

                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

                    <button class="btn bg-emerald-500 hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2
                                focus:ring-emerald-600 text-white">GUARDAR</button>
                </div>
                {!! Form::close() !!}
            </div> --}}

        </div>
    </div>
</div>
@endsection


@section('js')

<script type="text/javascript">
    window.form = () => { 
      return {

        operador_v: {errorMessage:'', blurred:false},

        submit: function (event) {
          this.inputElements = [...this.$el.querySelectorAll("input[data-rules]")];
          this.inputElements.map((input) => {
            if (Iodine.is(input.value, JSON.parse(input.dataset.rules)) !== true) {
              const error = Iodine.is(input.value, JSON.parse(input.dataset.rules));
              event.preventDefault();
              input.classList.add("invalid");
              this[input.name].errorMessage = Iodine.getErrorMessage(error);
              console.log(Iodine.getErrorMessage(error));
            }else{
                input.classList.remove("invalid");
                this[input.name].errorMessage = "";
            }
          });
        }
      }
    }

// function handler() {
// return {
// fields: [],
// addNewField() {
// this.fields.push({
// sim_card: '',
// numero: '',
// operador: ''
// });
// },
// removeField(index) {
// this.fields.splice(index, 1);
// },
// saveForm(index) {
// alert(index);
// console.log(this.fields[index]);
// //You can process your form using fetch() or axios
// let web_api = '/contact';
// let response = fetch(web_api, {
// method: "POST",
// body: JSON.stringify(this.fields[index]),
// headers: {
// "Content-Type": "application/json",
// },
// }).then((response) => {
// if (!response.ok) {
// throw new Error("There was an error processing the request");
// }
// });
// }
// }
// }

</script>

@endsection