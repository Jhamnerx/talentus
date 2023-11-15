<div>
    {!! Form::open(['route' => 'admin.almacen.lineas.simcard.store', 'autocomplete' => 'off']) !!}

    <div class="bg-white sm:p-6 shadow-md rounded-md">
        <div class="grid grid-cols-12 gap-2 mb-1 relative ml-4">

            <div class="col-span-12 sm:col-span-12 mb-4 mx-3">
                <div>
                    {!! Form::label('numero', '1. Ingrese una línea:', [
                        'class' => 'block text-sm font-medium mb-1',
                    ]) !!}

                    <input name="numero" wire:model.live="numero" id="autocomplete-ajax-linea" type="text"
                        class="form-input w-full sm:w-1/2" placeholder="Ingresar Linea" maxlength="15">
                </div>
                <div class="text-xs mt-1">La Linea debe estar registrada!</div>


                @error('linea_id')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-12 mb-4 mx-3">

                <div>
                    {!! Form::label('sim_card', '3. Ingrese código de nuevo simcard:', [
                        'class' => 'block text-sm font-medium  mb-1',
                    ]) !!}

                    <input type="text" class="form-input w-full sm:w-1/2" wire:model.live="sim_card"
                        id="autocomplete-ajax-sim" placeholder="Escribe el sim card o selecciona">
                </div>

                <div class="text-xs mt-1">Si el sim card no se selecciona se verificara si existe o se creará si es
                    necesario!</div>
                @error('sim_card')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-12 mb-4 mx-3">
                {!! Form::label('motivo', '3. Motivo de cambio', ['class' => 'block text-sm font-medium mb-1']) !!}
                <input name="motivo" type="text" class="form-input w-full sm:w-1/2 "
                    placeholder="Escribe el motivo">


                @error('motivo')
                    <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>


        </div>
        <div class="px-4 py-3 text-right sm:px-6 mb-1 border-t-2 border-t-slate-400">

            <button type="button" wire:click.prevent="save"
                class="btn bg-emerald-500 hover:cursor-pointer hover:bg-emerald-600 focus:outline-none text-white">
                Asignar
            </button>

        </div>
    </div>

    {!! Form::close() !!}

</div>
@section('js')
    <script></script>
    <script>
        $('#autocomplete-ajax-sim').devbridgeAutocomplete({
            lookup: function(query, done) {
                $.ajax({
                    url: "{{ route('search.sim_card') }}",
                    dataType: 'json',
                    data: {
                        term: query
                    },
                    success: function(data) {
                        done(data);
                    }
                })

            },
            minChars: 2,
            autoSelectFirst: false,
            deferRequestBy: 5,
            onSelect: function(suggestion) {

                @this.set('sim_card', suggestion.value);
                @this.set('sim_card_id', suggestion.data);
            },
            onHint: function(hint) {
                $('#sim_card_id').val(hint);

            },
            onSearchComplete: function(query, suggestions) {

            },
            onInvalidateSelection: function() {
                $('#selction-ajax').html('You selected: none');
            },

        });

        $('#autocomplete-ajax-linea').devbridgeAutocomplete({
            lookup: function(query, done) {

                $.ajax({
                    url: "{{ route('search.lineas') }}",
                    dataType: 'json',
                    data: {
                        term: query
                    },
                    success: function(data) {

                        done(data);
                    }
                })

            },

            minChars: 2,
            autoSelectFirst: false,
            deferRequestBy: 5,
            onSelect: function(suggestion) {
                @this.set('numero', suggestion.value);
                @this.set('linea_id', suggestion.data);

            },
            onHint: function(hint) {
                $('#linea_id').val(hint);

            },
            onSearchComplete: function(query, suggestions) {

            },
            onInvalidateSelection: function() {
                $('#selction-ajax').html('You selected: none');
            },

        });
    </script>
@stop
