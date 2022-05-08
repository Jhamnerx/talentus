@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')
@section('contenido')

<!-- Table -->
@livewire('admin.ventas.presupuestos.presupuestos-index')

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
    function config(){

        var array ={
		
            emptyOptionsMessage: 'No countries match your search.', 
            name: 'country', 
            placeholder: 'Select a country',
            data: 
                { 
                    au: 'Australia', 
                    be: 'Belgium', 
                    cn: 'China', 
                    fr: 'France', 
                    de: 'Germany', 
                    it: 'Italy', 
                    mx: 'Mexico', 
                    es: 'Spain',
                    tr: 'Turkey', 
                    gb: 'United Kingdom', 
                    us: 'United States' 
                }, 

            
        };


        
        $.ajax({
            url: "{{route('busqueda.clientes')}}",

            success: function(data){

                //done(data);

               // return data;
                console.log(data);
            }
        })
    }

    config();
</script>
@stop