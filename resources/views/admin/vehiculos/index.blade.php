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
    function select(config) {
            return {

                data: config.data,

                emptyOptionsMessage: 'No hay resultados.',

                focusedOptionIndex: null,

                name: 'flotas',

                name: config.name,

                open: false,
                selected: 0,

                options: {},

                placeholder: config.placeholder ?? 'Selecciona una Flota',

                search: '',

                value: config.value,

                closeListbox: function () {
                    this.open = false

                    this.focusedOptionIndex = null

                    this.search = ''
                },

                focusNextOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options).length - 1

                    if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

                    this.focusedOptionIndex++

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: "center",
                    })
                },

                focusPreviousOption: function () {
                    if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

                    if (this.focusedOptionIndex <= 0) return

                    this.focusedOptionIndex--

                    this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                        block: "center",
                    })
                },

                init: function () {

                    this.options = this.data

                    //console.log(this.data);

                    if (!(this.value in this.options)) this.value = null

                    this.$watch('search', ((value) => {
                        if (!this.open || !value) return this.options = this.data

                        this.options = Object.keys(this.data)
                            .filter((key) => this.data[key].toLowerCase().includes(value.toLowerCase()))
                            .reduce((options, key) => {
                                options[key] = this.data[key]
                                return options
                            }, {})
                    }))
                    

                },

                selectOption: function () {

                    if (!this.open) return this.toggleListboxVisibility()

                    this.value = Object.keys(this.options)[this.focusedOptionIndex]
                    console.log(this.value);
                    this.selected = this.value;
                    this.closeListbox()
                },

                toggleListboxVisibility: function () {
                    if (this.open) return this.closeListbox()

                    this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)

                    if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                    this.open = true

                    this.$nextTick(() => {
                        this.$refs.search.focus()

                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center"
                        })
                    })
                },
            }
    }
</script>

<script>
    $('#numero').devbridgeAutocomplete({
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

                    }
                })

            },

            minChars: 2,
            autoSelectFirst: false,
            deferRequestBy: 5,
            onSelect: function(suggestion) {

                $('#operador').val(suggestion.operador);
                $('#sim_card').val(suggestion.sim_card);

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