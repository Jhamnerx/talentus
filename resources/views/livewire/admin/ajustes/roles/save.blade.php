<x-form.modal.card title="Crear Rol" blur wire:model.live="openModalSave" align="center" max-width='6xl'>


    <div class="px-4 md:px-8 py-4 md:py-6">
        <div class="relative w-full text-left mt-3">
            <label for="rol_name"
                class="flex text-sm not-italic items-center font-medium text-gray-800 whitespace-nowrap justify-between">

                <div>
                    Nombre
                    <span class="text-sm text-red-500"> * </span>
                </div>


            </label>
            <div class="flex flex-col mt-1">

                <div class="relative rounded-md shadow-sm font-base">

                    <input id="rol_name" name="rol_name" wire:model.live="name" type="text"
                        class="font-base block w-full sm:text-sm border-gray-200 rounded-md text-black focus:ring-indigo-400 focus:border-indigo-400"
                        tabindex="0">


                </div>


            </div>
            @error('name')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="flex justify-between">
        <h6 class="text-sm not-italic font-medium text-gray-800 px-4 md:px-8 py-1.5">
            Permisos
            <span class="text-sm text-red-500"> *</span>
        </h6>
        @error('permission')
            <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                {{ $message }}
            </p>
        @enderror
        <div class="text-sm not-italic font-medium text-gray-300 px-4 md:px-8 py-1.5">

            <x-form.button label="Seleccionar todo" flat primary spinner="checkAll" wire:click.prevent="checkAll" />
            /
            <x-form.button label="Ninguno" flat primary spinner="uncheckAll" wire:click.prevent="uncheckAll" />

        </div>
    </div>

    <div class="border-t border-gray-200 py-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 px-8 sm:px-8">

            {{-- CATEGORIA --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('categoria')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Categorias</p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-categoria'
                    label='Ver Categoria' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-categoria'
                    label='Crear Categoria' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-categoria'
                    label='Editar Categoria' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='cambiar.estado-categoria'
                    label='cambiar estado categoria' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-categoria'
                    label='eliminar categoria' />

            </div>

            {{-- PRODUCTOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('producto')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Productos</p>


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-producto'
                    label='ver producto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-producto'
                    label='crear producto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-producto'
                    label='editar producto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='cambiar.estado-producto'
                    label='cambiar estado producto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-producto'
                    label='eliminar producto' />

            </div>

            {{-- SIM CARD Y LINEAS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('sim_card')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">Sim
                    Card y Lineas
                </p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-sim_card'
                    label='ver sim y lineas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-sim_card'
                    label='crear sim y lineas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-sim_card'
                    label='editar sim y lineas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='asignar.linea-sim_card'
                    label='asignar linea' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar.numero-sim_card'
                    label='eliminar numero de sim card' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-sim_card'
                    label='eliminar' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver.cambios-sim_card'
                    label='ver cambios sim card' />


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='importar-sim_card'
                    label='importar sim card' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='exportar-sim_card'
                    label='exportar sim card' />

            </div>
            {{-- DISPOSITIVOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('dispositivo')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Dispositivos
                </p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-dispositivo'
                    label='ver dispositivos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='ver.modelos-dispositivo' label='ver modelos dispositivos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-dispositivo'
                    label='crear dispositivos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-dispositivo'
                    label='editar dispositivo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-dispositivo'
                    label='eliminar dispositivo' />


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='importar-dispositivo'
                    label='importar dispositivos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='exportar-dispositivo'
                    label='exportar dispositivos' />

            </div>

            {{-- GUIAS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('guias')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Guias</p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-guias'
                    label='ver guias' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-guias'
                    label='crear guias' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-guias'
                    label='editar guias' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='detalle-guias'
                    label='ver detalle guias' />


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-guias'
                    label='eliminar guias' />
            </div>

            {{-- CLIENTES --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('cliente')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Clientes
                </p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-cliente'
                    label='ver clientes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-cliente'
                    label='crear clientes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-cliente'
                    label='editar clientes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='cambiar.estado-cliente'
                    label='cambiar estados clientes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-cliente'
                    label='eliminar clientes' />


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='exportar-cliente'
                    label='exportar clientes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='importar-cliente'
                    label='importar clientes' />

            </div>
            {{-- CONTACTOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('contacto')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Contactos</p>


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-contacto'
                    label='ver contacto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-contacto'
                    label='crear contacto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-contacto'
                    label='editar contacto' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-contacto'
                    label='eliminar contacto' />

            </div>
            {{-- PROVEEDORES --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('proveedor')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Proveedores</p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-proveedor'
                    label='ver proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-proveedor'
                    label='crear proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-proveedor'
                    label='editar proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-proveedor'
                    label='eliminar proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='cambiar.estado-proveedor' label='cambiar estado proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='exportar-proveedor'
                    label='exportar proveedor' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='importar-proveedor'
                    label='exportar importar' />

            </div>

            {{-- FACTURAS COMPRA --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('compras_facturas')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Facturas Compras
                </p>

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-compras_facturas'
                    label='ver facturas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-compras_facturas'
                    label='crear facturas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='editar-compras_facturas' label='editar facturas' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='eliminar-compras_facturas' label='eliminar facturas' />

            </div>
            {{-- COTIZACIONES --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('cotizaciones')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Cotizaciones</p>



                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-cotizaciones'
                    label='ver cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-cotizaciones'
                    label='crear cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-cotizaciones'
                    label='editar cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-cotizaciones'
                    label='eliminar cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='convertir-cotizaciones'
                    label='convertir cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='enviar-cotizaciones'
                    label='enviar cotizaciones' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='estados-cotizaciones'
                    label='cambiar estados' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='descargar-cotizaciones'
                    label='Descargar cotizaciones' />

            </div>
            {{-- COMPROBANTES --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkComprobantesPermisos()"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Comprobantes</p>


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-comprobantes'
                    label='ver comprobantes' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-emitir-factura' label='emitir factura' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-emitir-boleta' label='emitir boleta' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-emitir-nota-venta' label='emitir nota venta' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-emitir-nota-credito' label='emitir nota credito' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-emitir-nota-debito' label='emitir nota debito' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-descargar-pdf' label='Descargar pdf' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-descargar-xml' label='Descargar xml' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-ver-nota-credito' label='ver nota credito' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-ver-nota-debito' label='ver nota debito' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-nota-credito-pdf' label='Descargar pdf nota c' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-nota-credito-xml' label='Descargar xml nota c' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-nota-debito-pdf' label='Descargar pdf nota d' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='comprobantes-nota-debito-xml' label='Descargar xml nota d' />


            </div>

            {{-- RECIBOS --}}
            <div class="flex flex-col space-y-1">

                <p wire:click="checkCategory('recibo')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Recibos
                </p>


                <x-admin.settings.permiso-input name='permission[]' model="permission" value='ver-recibos'
                    label='ver recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='crear-recibos'
                    label='crear recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='editar-recibos'
                    label='editar recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='eliminar-recibos'
                    label='eliminar recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='convertir-recibos'
                    label='convertir recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='enviar-recibos'
                    label='enviar recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='estados-recibos'
                    label='cambiar estados' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='descargar-recibos'
                    label='Descargar recibo' />

                <x-admin.settings.permiso-input name='permission[]' model="permission" value='reportes-recibos'
                    label='Reporte recibo' />


            </div>
            {{-- CONTRATOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('contrato')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Contratos
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="ver-contrato"
                                variant="indigo" type="checkbox" id="ver-contrato"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-contrato" class="font-medium text-gray-600 cursor-pointer">
                                ver contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" id="crear-contrato" wire:model.live="permission"
                                value="crear-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-contrato" class="font-medium text-gray-600 cursor-pointer">
                                crear contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="editar-contrato"
                                id="editar-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-contrato" class="font-medium text-gray-600 cursor-pointer">
                                editar contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="descargar-contrato"
                                id="descargar-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="descargar-contrato" class="font-medium text-gray-600 cursor-pointer">
                                descargar contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="caracteristicas-contrato"
                                id="caracteristicas-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="caracteristicas-contrato" class="font-medium text-gray-600 cursor-pointer">
                                cambiar caracteristicas
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="cambiar.estado-contrato"
                                id="cambiar.estado-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="cambiar.estado-contrato" class="font-medium text-gray-600 cursor-pointer">
                                cambiar estado contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" id="enviar-contrato" wire:model.live="permission"
                                value="enviar-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="enviar-contrato" class="font-medium text-gray-600 cursor-pointer">
                                enviar contrato
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" id="crear-registro-contrato" wire:model.live="permission"
                                value="crear-registro-contrato" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-registro-contrato" class="font-medium text-gray-600 cursor-pointer">
                                convertir a registro cobro
                            </label>

                        </div>
                    </div>
                </div>
            </div>
            {{-- VEHICULOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('vehiculos-vehiculos')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Vehiculos</p>


                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='ver-vehiculos-vehiculos' label='ver vehiculos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='crear-vehiculos-vehiculos' label='crear vehiculos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='editar-vehiculos-vehiculos' label='editar vehiculos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='eliminar-vehiculos-vehiculos' label='eliminar vehiculos' />


                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='exportar.vehiculos-vehiculos' label='exportar vehiculos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='importar-vehiculos-vehiculos' label='importar vehiculos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='show-vehiculos-vehiculos' label='ver info vehiculos' />

            </div>

            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('vehiculos-flotas')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Flotas</p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="ver-vehiculos-flotas"
                                id="ver-vehiculos-flotas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-vehiculos-flotas" class="font-medium text-gray-600 cursor-pointer">
                                ver flotas
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="crear-vehiculos-flotas"
                                id="crear-vehiculos-flotas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-vehiculos-flotas" class="font-medium text-gray-600 cursor-pointer">
                                crear flotas
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="editar-vehiculos-flotas"
                                id="editar-vehiculos-flotas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-vehiculos-flotas" class="font-medium text-gray-600 cursor-pointer">
                                editar flotas
                            </label>

                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="eliminar-vehiculos-flotas"
                                id="eliminar-vehiculos-flotas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="eliminar-vehiculos-flotas" class="font-medium text-gray-600 cursor-pointer">
                                eliminar flotas
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            {{-- MANTENIMIENTO --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkMantenimiento"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Mantenimiento</p>

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='ver-mantenimientos-vehiculos' label='ver mantenimientos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='crear-mantenimientos-vehiculos' label='crear mantenimientos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='editar-mantenimientos-vehiculos' label='editar mantenimientos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='eliminar-mantenimientos-vehiculos' label='eliminar mantenimientos' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='task-mantenimientos-vehiculos' label='tareas de mantenimiento' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='mark-mantenimientos-vehiculos' label='marcar como manten...' />

                <x-admin.settings.permiso-input name='permission[]' model="permission"
                    value='exportar-mantenimientos-vehiculos' label='exportar mantenimiento' />


            </div>


            {{-- REPORTES --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('vehiculos-reportes')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Reportes</p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="ver-vehiculos-reportes"
                                id="ver-vehiculos-reportes" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-vehiculos-reportes" class="font-medium text-gray-600 cursor-pointer">
                                ver reportes
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="crear-vehiculos-reportes"
                                id="crear-vehiculos-reportes" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-vehiculos-reportes" class="font-medium text-gray-600 cursor-pointer">
                                crear reportes
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="editar-vehiculos-reportes"
                                id="editar-vehiculos-reportes" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-vehiculos-reportes" class="font-medium text-gray-600 cursor-pointer">
                                editar reportes
                            </label>

                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="eliminar-vehiculos-reportes" id="eliminar-vehiculos-reportes" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="eliminar-vehiculos-reportes" class="font-medium text-gray-600 cursor-pointer">
                                eliminar reportes
                            </label>

                        </div>
                    </div>
                </div>
            </div>


            {{-- ACTAS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('certificados-actas')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Actas
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="ver-certificados-actas"
                                id="ver-certificados-actas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-certificados-actas" class="font-medium text-gray-600 cursor-pointer">
                                ver actas
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="crear-certificados-actas"
                                id="crear-certificados-actas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-certificados-actas" class="font-medium text-gray-600 cursor-pointer">
                                crear actas
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="editar-certificados-actas"
                                id="editar-certificados-actas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-certificados-actas" class="font-medium text-gray-600 cursor-pointer">
                                editar acta
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="descargar-certificados-actas" id="descargar-certificados-actas"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="descargar-certificados-actas"
                                class="font-medium text-gray-600 cursor-pointer">
                                descargar acta
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="enviar-certificados-actas"
                                id="enviar-certificados-actas" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="enviar-certificados-actas" class="font-medium text-gray-600 cursor-pointer">
                                enviar acta
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="eliminar-certificados-actas" id="eliminar-certificados-actas" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="eliminar-certificados-actas" class="font-medium text-gray-600 cursor-pointer">
                                eliminar actas
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            {{-- CERTIFICADOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('certificados-gps')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Certificados</p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="ver-certificados-gps"
                                id="ver-certificados-gps" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                ver certificado
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="crear-certificados-gps"
                                id="crear-certificados-gps" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                crear certificado
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="editar-certificados-gps"
                                id="editar-certificados-gps" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                editar certificado
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="descargar-certificados-gps" id="descargar-certificados-gps" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="descargar-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                descargar certificado
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="enviar-certificados-gps"
                                id="enviar-certificados-gps" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="enviar-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                enviar certificado
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="eliminar-certificados-gps"
                                id="eliminar-certificados-gps" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="eliminar-certificados-gps" class="font-medium text-gray-600 cursor-pointer">
                                eliminar certificado
                            </label>

                        </div>
                    </div>
                </div>
            </div>
            {{-- CERTIFICADOS VELO --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('certificados-velocimetros')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Certificado Velocimetros
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="ver-certificados-velocimetros" id="ver-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="ver-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                ver cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="crear-certificados-velocimetros" id="crear-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="crear-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                crear cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="editar-certificados-velocimetros" id="editar-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="editar-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                editar cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="descargar-certificados-velocimetros" id="descargar-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="descargar-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                descargar cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="enviar-certificados-velocimetros" id="enviar-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="enviar-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                enviar cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="eliminar-certificados-velocimetros" id="eliminar-certificados-velocimetros"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="eliminar-certificados-velocimetros"
                                class="font-medium text-gray-600 cursor-pointer">
                                eliminar cert. velocimetro
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ADMIN PERMISOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('solicitudes')"
                    class="text-sm text-gray-700 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Solicitudes
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.solicitudes.index"
                                id="admin.solicitudes.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.solicitudes.index" class="font-medium text-gray-600 cursor-pointer">
                                ver solicitudes
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.solicitudes.finalize" id="admin.solicitudes.finalize" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.solicitudes.finalize" class="font-medium text-gray-600 cursor-pointer">
                                Finalizar solicitud
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.reportes.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Reportes Gerenciales
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.reportes.index"
                                id="admin.reportes.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.reportes.index" class="font-medium text-gray-600 cursor-pointer">
                                ver reportes y descargar
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.reportes.logs.index" id="admin.reportes.logs.index" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.reportes.logs.index" class="font-medium text-gray-600 cursor-pointer">
                                Ver logs y cambios
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.reportes.logs.actions" id="admin.reportes.logs.actions"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.reportes.logs.actions"
                                class="font-medium text-gray-600 cursor-pointer">
                                Modificar logs y recuperar
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            {{-- USUARIOS --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.usuarios.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Usuarios sistema
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.usuarios.index"
                                id="admin.usuarios.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.usuarios.index" class="font-medium text-gray-600 cursor-pointer">
                                ver usuarios
                            </label>

                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.usuarios.create"
                                id="admin.usuarios.create" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.usuarios.create" class="font-medium text-gray-600 cursor-pointer">
                                crear usuarios
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.usuarios.edit"
                                id="admin.usuarios.edit" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.usuarios.edit" class="font-medium text-gray-600 cursor-pointer">
                                editar usuarios
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.usuarios.status"
                                id="admin.usuarios.status" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.usuarios.status" class="font-medium text-gray-600 cursor-pointer">
                                cambiar estado usuarios
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.usuarios.delete"
                                id="admin.usuarios.delete" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.usuarios.delete" class="font-medium text-gray-600 cursor-pointer">
                                eliminar usuarios
                            </label>

                        </div>
                    </div>
                </div>

            </div>

            {{-- cobros --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.cobros.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Cobros
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.cobros.index"
                                id="admin.cobros.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.cobros.index" class="font-medium text-gray-600 cursor-pointer">
                                ver cobros
                            </label>

                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.cobros.create"
                                id="admin.cobros.create" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.cobros.create" class="font-medium text-gray-600 cursor-pointer">
                                crear cobros
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" id="admin.cobros.edit"
                                value="admin.cobros.edit" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.cobros.edit" class="font-medium text-gray-600 cursor-pointer">
                                editar cobros
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.cobros.delete"
                                id="admin.cobros.delete" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.cobros.delete" class="font-medium text-gray-600 cursor-pointer">
                                eliminar cobros
                            </label>

                        </div>
                    </div>
                </div>

            </div>

            {{-- payments --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.payments.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Pagos
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.payments.index"
                                id="admin.payments.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.payments.index" class="font-medium text-gray-600 cursor-pointer">
                                ver pagos
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="admin.payments.create"
                                id="admin.payments.create" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.payments.create" class="font-medium text-gray-600 cursor-pointer">
                                crear pagos
                            </label>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ciudades --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.settings.ciudades.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Ciudades
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.ciudades.index" id="admin.settings.ciudades.index"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.ciudades.index"
                                class="font-medium text-gray-600 cursor-pointer">
                                ver ciudades
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.ciudades.create" id="admin.settings.ciudades.create"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.ciudades.create"
                                class="font-medium text-gray-600 cursor-pointer">
                                crear ciudades
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.ciudades.edit" id="admin.settings.ciudades.edit"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.ciudades.edit"
                                class="font-medium text-gray-600 cursor-pointer">
                                editar ciudades
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.ciudades.delete" id="admin.settings.ciudades.delete"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.ciudades.delete"
                                class="font-medium text-gray-600 cursor-pointer">

                                eliminar ciudades
                            </label>

                        </div>
                    </div>
                </div>

            </div>

            {{-- roles --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('settings.roles')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Roles
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.roles.index" id="admin.settings.roles.index"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.roles.index"
                                class="font-medium text-gray-600 cursor-pointer">
                                ver roles
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.roles.create" id="admin.settings.roles.create"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.roles.create"
                                class="font-medium text-gray-600 cursor-pointer">
                                crear roles
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.roles.edit" id="admin.settings.roles.edit" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.roles.edit" class="font-medium text-gray-600 cursor-pointer">
                                editar roles
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.roles.delete" id="admin.settings.roles.delete"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.roles.delete"
                                class="font-medium text-gray-600 cursor-pointer">
                                editar eliminar
                            </label>

                        </div>
                    </div>
                </div>

            </div>

            {{-- plantilla --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('.settings.plantilla.')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Administración Plantilla
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                id="admin.settings.plantilla.index" value="admin.settings.plantilla.index"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.plantilla.index"
                                class="font-medium text-gray-600 cursor-pointer">
                                ver informacion
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.plantilla.informacion.edit"
                                id="admin.settings.plantilla.informacion.edit" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.plantilla.informacion.edit"
                                class="font-medium text-gray-600 cursor-pointer">
                                editar informacion
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.plantilla.sunat.edit" id="admin.settings.plantilla.sunat.edit"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.plantilla.sunat.edit"
                                class="font-medium text-gray-600 cursor-pointer">
                                Actualizar Accesos Sunat
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.plantilla.series.edit"
                                id="admin.settings.plantilla.series.edit" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.plantilla.series.edit"
                                class="font-medium text-gray-600 cursor-pointer">
                                Actualizar series
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="admin.settings.plantilla.images.edit"
                                id="admin.settings.plantilla.images.edi" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="admin.settings.plantilla.images.edi"
                                class="font-medium text-gray-600 cursor-pointer">
                                Actualizar imagenes
                            </label>

                        </div>
                    </div>
                </div>

            </div>

            {{-- servicio tecnico --}}
            <div class="flex flex-col space-y-1">
                <p wire:click="checkCategory('tareas')"
                    class="text-sm text-gray-500 border-b border-gray-200 pb-1 mb-2 cursor-pointer">
                    Servicio Tecnico
                </p>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="tecnico.tareas.index"
                                id="tecnico.tareas.index" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.index" class="font-medium text-gray-600 cursor-pointer">
                                ver modulo
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.reportes" id="tecnico.tareas.reportes" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.reportes" class="font-medium text-gray-600 cursor-pointer">
                                descargar reportes
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="tecnico.tareas.cards"
                                id="tecnico.tareas.cards" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.cards" class="font-medium text-gray-600 cursor-pointer">
                                Ver resumenes tabla
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.cards.sin-leer.actions" id="tecnico.tareas.cards.sin-leer"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.cards.sin-leer"
                                class="font-medium text-gray-800 cursor-pointer">
                                Acciones: Tabla Sin Leer
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.cards.complete.actions"
                                id="tecnico.tareas.cards.complete.actions" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.cards.complete.actions"
                                class="font-medium text-gray-800 cursor-pointer">
                                Acciones: Tabla Completados
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.cards.pendient.actions"
                                id="tecnico.tareas.cards.pendient.actions" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.cards.pendient.actions"
                                class="font-medium text-gray-800 cursor-pointer">
                                Acciones: Tabla Pendientes
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.cards.canceled.actions"
                                id="tecnico.tareas.cards.canceled.actions" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.cards.canceled.actions"
                                class="font-medium text-gray-800 cursor-pointer">
                                Acciones: Tabla Cancelados
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tecnicos.admin" id="tecnico.tareas.tecnicos.admin"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tecnicos.admin"
                                class="font-medium text-gray-800 cursor-pointer">
                                Administrar Tecnicos
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tabla-historial" id="tecnico.tareas.tabla-historial"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tabla-historial"
                                class="font-medium text-gray-800 cursor-pointer">
                                Ver Tabla Historial
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="tecnico.tareas.create"
                                id="tecnico.tareas.create" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.create" class="font-medium text-gray-800 cursor-pointer">
                                Crear Tarea
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="tecnico.tareas.edit"
                                id="tecnico.tareas.edit" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.edit" class="font-medium text-gray-800 cursor-pointer">
                                Editar Tarea
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission" value="tecnico.tareas.delete"
                                id="tecnico.tareas.delete" variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.delete" class="font-medium text-gray-800 cursor-pointer">
                                Eliminar Tarea
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.action.pdf" id="tecnico.tareas.action.pdf" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.action.pdf" class="font-medium text-gray-800 cursor-pointer">
                                Accion: Descargar PDF
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.action.wsp" id="tecnico.tareas.action.wsp" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.action.wsp" class="font-medium text-gray-800 cursor-pointer">
                                Accion: Enviar WhatsApp
                            </label>

                        </div>
                    </div>
                </div>

                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tipo.index" id="tecnico.tareas.tipo.index" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tipo.index" class="font-medium text-gray-600 cursor-pointer">
                                Tipo Tarea: Ver
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tipo.create" id="tecnico.tareas.tipo.create"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tipo.create"
                                class="font-medium text-gray-600 cursor-pointer">
                                Tipo Tarea: Crear
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tipo.edit" id="tecnico.tareas.tipo.edit" variant="indigo"
                                type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tipo.edit" class="font-medium text-gray-600 cursor-pointer">
                                Tipo Tarea: Editar
                            </label>

                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="relative flex items-start" variant="indigo">
                        <div class="flex items-center h-5">
                            <input name="permission[]" wire:model.live="permission"
                                value="tecnico.tareas.tipo.delete" id="tecnico.tareas.tipo.delete"
                                variant="indigo" type="checkbox"
                                class="w-4 h-4 border-gray-300 rounded cursor-pointer text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="tecnico.tareas.tipo.delete"
                                class="font-medium text-gray-600 cursor-pointer">
                                Tipo Tarea: Eliminar
                            </label>

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">

            <div class="flex">
                <x-form.button flat label="Cancelar" x-on:click="close" />
                <x-form.button primary label="Guardar" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-form.modal.card>
