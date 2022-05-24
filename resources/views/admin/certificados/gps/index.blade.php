@extends('layouts.admin')
@section('ruta', 'certificados-gps')
@section('contenido')

<!-- Table -->
@livewire('admin.certificados.gps.certificados-gps-index')

@stop

@push('modals')

@livewire('admin.certificados.gps.save')
@livewire('admin.certificados.gps.edit')

@endpush

@section('js')
<script>
    window.addEventListener('certificado-edit', event => {
        iziToast.success({
            position: 'topRight',
            title: 'ACTUALIZADO',
            message: 'El Certificado N° '+event.detail.certificado+' Fue Actualizado',
        });

    })
    
</script>

<script>
    window.addEventListener('certificado-save', event => {
        $( document ).ready(function() {
        Swal.fire({
        icon: 'success',
        title: 'Guardado',
        text: 'El certificado de '+event.detail.vehiculo+' Fue Creado',
        showConfirmButton: true,
        confirmButtonText: "Cerrar"

        })
    });
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