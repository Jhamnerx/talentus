<div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">
    <div class="max-w-3xl  col-span-6">

        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-6">CONFIGURACIÓN EMPRESA</h3>

    </div>

    <div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">

        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">
            <div class="max-w-3xl col-span-12">

                <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">DATOS EMPRESARIALES</h3>

            </div>
            <div class="col-span-12 sm:col-span-5">
                <x-form.input maxlength="11" label="R.U.C:" placeholder="R.U.C." wire:model.live='ruc' />

            </div>
            <div class="col-span-12 sm:col-span-6">
                <x-form.input label="RAZON SOCIAL:" placeholder="RAZON SOCIAL:" wire:model.live='razon_social' />

            </div>
            <div class="col-span-12 sm:col-span-4">
                <x-form.input label="NOMBRE COMERCIAL:" placeholder="NOMBRE COMERCIAL:"
                    wire:model.live='nombre_comercial' />

            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-form.inputs.phone label="TELEFONO:" wire:model.live='telefono' placeholder="987654321" maxlength="9"
                    mask="#########" />

            </div>
            <div class="col-span-6 sm:col-span-2">
                <x-form.input class="!pl-[6.5rem]" label="I.G.V:" placeholder="18" prefix="%"
                    wire:model.live='igv' />

            </div>
            <div class="col-span-6 sm:col-span-2">

                <x-form.inputs.currency label="ICBPER" placeholder="0.50" wire:model.live="icbper" />

            </div>
            <div class="col-span-12 sm:col-span-3">

                <div class="w-full ">
                    <div class="flex justify-between items-end mb-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Modo Sistema
                        </label>
                    </div>
                    <div class="relative rounded-md">

                        <x-form.toggle md label="Produccion" wire:model.live="modo" />

                    </div>

                </div>


            </div>


            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.informacion.edit')
                    <x-form.button wire:click="saveInfo" spinner="saveInfo" loading-delay="short" positive
                        label="GUARDAR" />
                @endcan
            </div>
        </div>
    </div>

    <div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">
        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">

            <div class="max-w-3xl col-span-12">

                <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">TERMINOS</h3>

            </div>
            <div class="flex flex-auto gap-2 mx-4 py-2 col-span-12">
                <div class=""></div>
                <div class="w-full">
                    @can('admin.settings.plantilla.informacion.edit')
                        <x-form.button.circle wire:click.prevent="addItem" spinner="addItem" primary label="+"
                            class="float-right" />
                    @endcan
                </div>
            </div>
            @if ($terminos->isEmpty())

                <div class="col-span-12">
                    <span class="w-full text-red-500">Agregar Terminos</span>
                </div>
            @else
                @foreach ($terminos as $clave => $termino)
                    <div class="col-span-12 py-2">
                        <div class="flex gap-2">

                            <div class="col-span-12 sm:col-span-12 w-full">

                                <x-form.textarea label="TERMINO {{ $clave + 1 }}:" placeholder="ESCRIBA AQUI"
                                    wire:model.live='terminos.{{ $clave }}' />

                            </div>
                            @can('admin.settings.plantilla.informacion.edit')
                                <button type="button" wire:click.prevent="eliminar('{{ $clave }}')"
                                    class="text-rose-500 hover:text-rose-600 rounded-full">
                                    <span class="sr-only">Eliminar</span>
                                    <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
                                        <path d="M13 15h2v6h-2zM17 15h2v6h-2z" />
                                        <path
                                            d="M20 9c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v2H8v2h1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1V13h1v-2h-4V9zm-6 1h4v1h-4v-1zm7 3v9H11v-9h10z" />
                                    </svg>
                                </button>
                            @endcan
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.informacion.edit')
                    <x-form.button wire:click="saveTerminos" spinner="saveTerminos" loading-delay="short" positive
                        label="GUARDAR" />
                @endcan
            </div>

        </div>
    </div>

    <div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">
        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">
            <div class="max-w-3xl col-span-12">

                <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">DIRECCIÓN</h3>

            </div>
            <div class="col-span-12 sm:col-span-3">

                <x-form.input label="UBIGEO:" placeholder="UBIGEO" wire:model.live='direccion.ubigeo' />

            </div>

            <div class="col-span-12 sm:col-span-6">

                <x-form.input label="DIRECCION:" placeholder="DIRECCION" wire:model.live='direccion.direccion' />

            </div>

            <div class="col-span-12 sm:col-span-3">
                <x-form.input label="DEPARTAMENTO:" placeholder="DEPARTAMENTO"
                    wire:model.live='direccion.departamento' />
            </div>

            <div class="col-span-12 sm:col-span-2">
                <x-form.input label="PROVINCIA:" placeholder="PROVINCIA" wire:model.live='direccion.provincia' />

            </div>
            <div class="col-span-12 sm:col-span-2">
                <x-form.input label="DISTRITO:" placeholder="DISTRITO" wire:model.live='direccion.distrito' />

            </div>
            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.informacion.edit')
                    <x-form.button wire:click="saveDireccion" spinner="saveInfo" loading-delay="short" positive
                        label="GUARDAR" />
                @endcan
            </div>
        </div>
    </div>


    {{-- <div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">
        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">

            <div class="max-w-3xl col-span-12">

                <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">DATOS SUNAT</h3>

            </div>

            <div class="col-span-12 sm:col-span-3">

                <x-form.input label="USUARIO SOL SUNAT:" placeholder="USUARIO SOL SUNAT"
                    wire:model.live='sunat.usuario_sol_sunat' />

            </div>

            <div class="col-span-12 sm:col-span-3">
                <x-form.input label="CLAVE SOL SUNAT:" wire:model.live='sunat.clave_sol_sunat' />

            </div>

            <div class="col-span-12 sm:col-span-3">
                <x-form.input label="CLAVE CERTIFICADO
                    CDT:"
                    wire:model.live='sunat.clave_certificado_cdt' />
            </div>

            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.sunat.edit')
                    <x-form.button wire:click="saveSunat" spinner="saveSunat" loading-delay="short" positive
                        label="GUARDAR" />
                @endcan

            </div>

        </div>
    </div> --}}
    {{-- MAIL CONFIG --}}
    <div class="col-span-12 mx-3 rounded bg-white overflow-hidden shadow-2xl">
        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 px-3 mb-2">

            <div class="max-w-3xl col-span-12">

                <h3 class="text-base leading-snug text-slate-800 font-bold mb-6">CONFIGURACION DE CORREO</h3>

            </div>

            <div class="col-span-12 sm:col-span-3">

                <x-form.input type="email" label="CORREO:" placeholder="CORREO"
                    wire:model.live='mail_config.correo_ventas' />

            </div>

            <div class="col-span-12 sm:col-span-3">
                <x-form.input label="HOST:" placeholder="SERVIDOR DE CORREO"
                    wire:model.live='mail_config.servidor' />

            </div>

            <div class="col-span-12 sm:col-span-3">
                <x-form.input label="CONTRASEÑA:" placeholder="CONTRASEÑA" wire:model.live='mail_config.password' />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-form.input label="PUERTO:" placeholder="PORT" wire:model.live='mail_config.puerto' />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-form.input label="TLS/:" placeholder="ENCRIPTACION" wire:model.live='mail_config.seguridad' />
            </div>
            <div class="col-span-4 sm:col-span-2">
                <x-form.input label="TIPO:" placeholder="MAILER" wire:model.live='mail_config.tipo_envio' />
            </div>

            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.correo-config.edit')
                    <x-form.button wire:click="saveMail" spinner="saveSunat" loading-delay="short" positive
                        label="GUARDAR" />
                @endcan

            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {



        });
    </script>
@endpush
