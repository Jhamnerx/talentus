@extends('layouts.admin')
@section('contenido')

<!-- Table -->
@livewire('admin.certificados.actas.actas-index')

@stop

@push('modals')

@livewire('admin.certificados.actas.save')
@livewire('admin.certificados.actas.edit')

@endpush

@section('js')

<script>
    window.addEventListener('acta-delete', event => {
        iziToast.error({
            position: 'topRight',
            title: 'ELIMINADO',
            message: 'El Reporte de '+event.detail.vehiculo+' Fue Eliminado',
        });

    })
    
</script>
<script>
    window.addEventListener('acta-save', event => {
        $( document ).ready(function() {
        Swal.fire({
        icon: 'success',
        title: 'Guardado',
        text: 'El Acta de '+event.detail.vehiculo+' Fue Creado',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });
    })
    
</script>

<script>
    window.addEventListener('set-vehiculo', event => {
        //ESTABLECER EL VEHICULO PARA EDITAR ACTA
        var newOption = new Option(event.detail.vehiculo.placa, event.detail.vehiculo.id, false, false);
        $('.vehiculos_id').append(newOption).trigger('change');
        // ESTABLECER LA CIUDAD EN EDITAR
        var newOption = new Option(event.detail.ciudad.nombre, event.detail.ciudad.id, false, false);
        $('.ciudades').append(newOption).trigger('change');
    })
    
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
@stop