@extends('layouts.admin')
@section('ruta', 'almacen-dispositivos')
@section('contenido')

<!-- Table -->
@livewire('admin.dispositivos.dispositivos-index')


@stop

@section('js')

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

@if (session('store'))


<script>
    $( document ).ready(function() {
        Swal.fire({
        icon: 'success',
        title: 'Guardado',
        text: '{{session("store")}}',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });


</script>

@endif
@if (session('asign'))


<script>
    $( document ).ready(function() {
        Swal.fire({
        icon: 'success',
        title: 'Asignado',
        text: '{{session("asign")}}',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });


</script>

@endif
@if (session('update'))


<script>
    $( document ).ready(function() {
        Swal.fire({
        icon: 'success',
        title: 'Actualizado',
        text: '{{session("update")}}',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });


</script>

@endif

@if (session('delete'))


<script>
    $( document ).ready(function() {
        Swal.fire({
        icon: 'error',
        title: 'Eliminado',
        text: '{{session("delete")}}',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });


</script>

@endif



@stop