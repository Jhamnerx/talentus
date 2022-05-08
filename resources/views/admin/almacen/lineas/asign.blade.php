@extends('layouts.admin')
@section('ruta', 'almacen-lineas ')
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
        <h4 class="text-2xl font-bold leading-tight text-gray-800 dark:text-gray-100">ASIGNAR LINEAS</h4>
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
        <div class="mt-5 md:mt-0 md:col-span-7 ml-6">


            @livewire('admin.lineas.asign-linea', key($user->id))


        </div>


    </div>
</div>
@endsection


{{-- @section('js')
<script>
    $('#autocomplete-ajax').devbridgeAutocomplete({
            // serviceUrl: '/autosuggest/service/url',
            lookup: function (query, done) {

                // Do Ajax call or lookup locally, when done,
                // call the callback and pass your results:
                $.ajax({
                    url: "{{route('search.lineas')}}",
                    dataType: 'json',
                    data: {
                        term: query
                    },
                    success: function(data){

                        done(data);
                        //console.log(data);
                    }
                })

            },
            // serviceUrl: "{{route('search.lineas')}}",
            // type: 'GET',
            // dataType: 'json',

            minChars: 2,
            autoSelectFirst: false,
            deferRequestBy: 5,
            onSelect: function(suggestion) {

                $('#sim_card').val(suggestion.data);
                //@this.sim_card = suggestion.data
                Livewire.on('save', sim_card => suggestion.data)
            },
            onHint: function (hint) {
                $('#sim_card').val(hint);
            },
            onSearchComplete: function (query, suggestions) {

            },
            onInvalidateSelection: function() {
                $('#selction-ajax').html('You selected: none');
            },

        });


</script>
@stop --}}