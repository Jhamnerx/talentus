@extends('layouts.admin')
@section('ruta', 'ventas-presupuestos')
@section('contenido')

    <!-- Table -->
    @livewire('admin.ventas.presupuestos.presupuestos-index')
    @livewire('admin.ventas.presupuestos.send')
    @livewire('admin.ventas.presupuestos.delete')

@stop

@section('js')
    @if (session('store'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado',
                    text: '{{ session('store') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif

    @if (session('update'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado',
                    text: '{{ session('update') }}',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        </script>
    @endif


    <script>
        window.addEventListener('presupuesto-delete', event => {
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Eliminado',
                    text: 'Presupuesto Eliminado',
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"

                })
            });
        })
    </script>

    <script>
        window.addEventListener('save-invoice', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'FACTURA REGISTRADA',
                    message: 'Se registro una factura con el numero #' + event.detail.numero,
                });
            });
        })
    </script>

    <script>
        window.addEventListener('save-recibo', event => {
            $(document).ready(function() {
                iziToast.success({
                    position: 'topRight',
                    title: 'RECIBO REGISTRADO',
                    message: 'Se registro un recibo con el numero #' + event.detail.numero,
                });
            });
        })
    </script>
    <script>
        window.addEventListener('presupuesto-send', event => {
            iziToast.show({
                theme: 'dark',
                icon: 'far fa-envelope-open',
                title: 'CORREO ENVIADO<br>',
                timeout: 1500,
                message: 'Se ha enviado la cotización ' + event.detail.presupuesto.numero + '!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(5, 44, 82)'
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


                    let seleccionado = [];

                    for (let index = 0; index < checkboxes.length; index++) {
                        const element = checkboxes[index];

                        // seleccionado = [element.getAttribute('idPresupuesto')];
                        seleccionado.push(element.getAttribute('idPresupuesto'));


                        //console.log(element.getAttribute('idPresupuesto'));

                    }
                    console.log(seleccionado);

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
