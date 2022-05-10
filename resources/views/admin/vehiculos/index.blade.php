@extends('layouts.admin')
@section('ruta', 'vehiculos-vehiculos')
@section('contenido')

<!-- Table -->
@livewire('admin.vehiculos.vehiculos-index')

@stop

@section('js')
<script>
    console.log('Hi!'); 

</script>

<script>
    // A basic demo function to handle "select all" functionality
        document.addEventListener('alpine:init', () => {
            Alpine.data('handleSelect', () => ({
                selectall: false,
                selectAction() {
                    countEl = document.querySelector('.table-items-action');
                    if (!countEl) return;
                    checkboxes = document.querySelectorAll('input.table-item:checked');
                    document.querySelector('.table-items-count').innerHTML = checkboxes.length;
                    if (checkboxes.length > 0) {
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                },
                toggleAll() {
                    this.selectall = !this.selectall;
                    checkboxes = document.querySelectorAll('input.table-item');
                    [...checkboxes].map((el) => {
                        el.checked = this.selectall;
                    });
                    this.selectAction();
                },
                uncheckParent() {
                    this.selectall = false;
                    document.getElementById('parent-checkbox').checked = false;
                    this.selectAction();
                }
            }))
        })
</script>


<script>
    $('.numero').devbridgeAutocomplete({
        lookup: function (query, done) {
            $.ajax({
                url: "{{route('search.lineas')}}",
                dataType: 'json',
                data: {
                    term: query
                },
                success: function(data){

                    done(data);

                }
            })

        },
        minChars: 2,
        autoSelectFirst: false,
        deferRequestBy: 5,
        onSelect: function(suggestion) {

            //console.log(suggestion.operador);

            $('.operador').val(suggestion.operador);
            $('.sim_card').val(suggestion.sim_card);
            $('.sim_card_id').val(suggestion.sim_card_id);

        },
        onHint: function (hint) {
            //$('#numero').val(hint);
            //console.log(hint);


        },
        onSearchComplete: function (query, suggestions) {

        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        },

    });
</script>


<script>
    $('.dispositivo').devbridgeAutocomplete({
        lookup: function (query, done) {
            $.ajax({
                url: "{{route('search.dispositivos')}}",
                dataType: 'json',
                data: {
                    term: query
                },
                success: function(data){

                    done(data);

                }
            })

        },
        minChars: 2,
        autoSelectFirst: false,
        deferRequestBy: 5,
        onSelect: function(suggestion) {

            //console.log(suggestion.operador);

            $('.modelo').val(suggestion.modelo);
            $('.dispositivos_id').val(suggestion.data);
            // $('.sim_card').val(suggestion.sim_card);

        },
        onHint: function (hint) {
            //$('#numero').val(hint);
            //console.log(hint);


        },
        onSearchComplete: function (query, suggestions) {

        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        },

    });
</script>

@stop