<div>
    <!-- Profile background -->
    <div class="h-56 bg-slate-200">
        <img class="object-cover h-full w-full" src="{{ asset('storage/' . $plantilla->banner) }}" width="2560"
            height="440" alt="Company background" />
    </div>

    <!-- Header -->
    <header class="text-center bg-slate-50 pb-6 border-b border-slate-200">
        <div class="px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl mx-auto">

                <!-- Avatar -->
                <div class="-mt-12 mb-2">
                    <div class="inline-flex -ml-1 -mt-1 sm:mb-0">
                        <img class="rounded-full border-4 border-white" src="{{ asset('storage/' . $plantilla->logo) }}"
                            width="104" height="104" alt="Avatar" />
                    </div>
                </div>

                <!-- Company name and info -->
                <div class="mb-4">
                    <h2 class="text-2xl text-slate-800 font-bold mb-2">{{ $plantilla->razon_social }}</h2>

                </div>
                <!-- Meta -->
                <div class="inline-flex flex-wrap justify-center sm:justify-start space-x-4">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                            <path
                                d="M8 8.992a2 2 0 1 1-.002-3.998A2 2 0 0 1 8 8.992Zm-.7 6.694c-.1-.1-4.2-3.696-4.2-3.796C1.7 10.69 1 8.892 1 6.994 1 3.097 4.1 0 8 0s7 3.097 7 6.994c0 1.898-.7 3.697-2.1 4.996-.1.1-4.1 3.696-4.2 3.796-.4.3-1 .3-1.4-.1Zm-2.7-4.995L8 13.688l3.4-2.997c1-1 1.6-2.198 1.6-3.597 0-2.798-2.2-4.996-5-4.996S3 4.196 3 6.994c0 1.399.6 2.698 1.6 3.697 0-.1 0-.1 0 0Z" />
                        </svg>
                        <span class="text-sm font-medium whitespace-nowrap text-slate-500 ml-2">{{
                            $plantilla->direccion['region'] }},
                            PERÚ</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 fill-current shrink-0 text-slate-400" viewBox="0 0 16 16">
                            <path
                                d="M11 0c1.3 0 2.6.5 3.5 1.5 1 .9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.4 3.5l-1.2 1.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l1.1-1.2c.6-.5.9-1.3.9-2.1s-.3-1.6-.9-2.2C12 1.7 10 1.7 8.9 2.8L7.7 4c-.4.4-1 .4-1.4 0-.4-.4-.4-1 0-1.4l1.2-1.1C8.4.5 9.7 0 11 0ZM8.3 12c.4-.4 1-.5 1.4-.1.4.4.4 1 0 1.4l-1.2 1.2C7.6 15.5 6.3 16 5 16c-1.3 0-2.6-.5-3.5-1.5C.5 13.6 0 12.3 0 11c0-1.3.5-2.6 1.5-3.5l1.1-1.2c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4L2.9 8.9c-.6.5-.9 1.3-.9 2.1s.3 1.6.9 2.2c1.1 1.1 3.1 1.1 4.2 0L8.3 12Zm1.1-6.8c.4-.4 1-.4 1.4 0 .4.4.4 1 0 1.4l-4.2 4.2c-.2.2-.5.3-.7.3-.2 0-.5-.1-.7-.3-.4-.4-.4-1 0-1.4l4.2-4.2Z" />
                        </svg>
                        <a class="text-sm font-medium whitespace-nowrap text-indigo-500 hover:text-indigo-600 ml-2"
                            href="#0">{{ $plantilla->razon_social }}</a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Page content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full bg-white">
        <div class="max-w-3xl mx-auto ">

            <h3 class="text-xl leading-snug text-slate-800 font-bold mb-6">CONFIGURACION EMPRESA</h3>




        </div>

        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

            <!-- separador -->
            <div class="col-span-12">
                <div class="flex justify-between items-center" aria-hidden="true">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                    <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                        <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                    </div>
                    <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="ruc">RUC:</label>
                <div class="relative">
                    <input type="text" class="form-input w-full pl-9" wire:model='ruc'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path
                                    d="M38,21V2H9A2,2,0,0,0,7,4V60a2,2,0,0,0,2,2H55a2,2,0,0,0,2-2V21ZM19,18h9a1,1,0,0,1,0,2H19a1,1,0,0,1,0-2ZM45,50H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Zm0-10H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Zm0-10H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Z">
                                </path>
                                <polygon data-color="color-2" points="40 2.586 40 19 56.414 19 40 2.586"></polygon>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('ruc')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-6">

                <label class="block text-sm font-medium mb-1" for="razon_social">RAZON SOCIAL:</label>

                <div class="relative">
                    <input type="text" class="form-input w-full pl-9" wire:model='razon_social'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path
                                    d="M38,21V2H9A2,2,0,0,0,7,4V60a2,2,0,0,0,2,2H55a2,2,0,0,0,2-2V21ZM19,18h9a1,1,0,0,1,0,2H19a1,1,0,0,1,0-2ZM45,50H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Zm0-10H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Zm0-10H19a1,1,0,0,1,0-2H45a1,1,0,0,1,0,2Z">
                                </path>
                                <polygon data-color="color-2" points="40 2.586 40 19 56.414 19 40 2.586"></polygon>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('razon_social')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="telefono">TELEFONO:</label>
                <div class="relative">
                    <input type="text" class="form-input w-full pl-9" wire:model='telefono'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g fill="currentColor" class="nc-icon-wrapper">
                                <path data-color="color-2"
                                    d="M46,21a1,1,0,0,1-1-1A17.019,17.019,0,0,0,28,3a1,1,0,0,1,0-2A19.021,19.021,0,0,1,47,20,1,1,0,0,1,46,21Z">
                                </path>
                                <path data-color="color-2"
                                    d="M38,21a1,1,0,0,1-1-1,9.01,9.01,0,0,0-9-9,1,1,0,0,1,0-2A11.013,11.013,0,0,1,39,20,1,1,0,0,1,38,21Z">
                                </path>
                                <path
                                    d="M31.376,29.175,27.79,33.658A37.835,37.835,0,0,1,14.343,20.212l4.483-3.586a3.047,3.047,0,0,0,.88-3.614l-4.087-9.2A3.045,3.045,0,0,0,12.068,2.1L4.29,4.115A3.066,3.066,0,0,0,2.029,7.5,45.2,45.2,0,0,0,40.5,45.971a3.062,3.062,0,0,0,3.383-2.26L45.9,35.932a3.047,3.047,0,0,0-1.712-3.551L34.99,28.3A3.046,3.046,0,0,0,31.376,29.175Z">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('telefono')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>


            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="ubigeo">UBIGEO:</label>
                <div class="relative">
                    <input type="text" placeholder="INGRESA TU UBIGEO" class="form-input w-full pl-9"
                        wire:model='direccion.ubigeo'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 1.74.5 3.37 1.41 4.84.95 1.54 2.2 2.86 3.16 4.4.47.75.81 1.45 1.17 2.26.26.55.47 1.5 1.26 1.5s1-.95 1.25-1.5c.37-.81.7-1.51 1.17-2.26.96-1.53 2.21-2.85 3.16-4.4C18.5 12.37 19 10.74 19 9c0-3.87-3.13-7-7-7zm0 9.75a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('direccion.ubigeo')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-6">
                <label class="block text-sm font-medium mb-1" for="direccion">DIRECCION:</label>
                <div class="relative">
                    <input type="text" placeholder="INGRESA UNA DIRECCION" class="form-input w-full pl-9"
                        wire:model='direccion.direccion'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 1.74.5 3.37 1.41 4.84.95 1.54 2.2 2.86 3.16 4.4.47.75.81 1.45 1.17 2.26.26.55.47 1.5 1.26 1.5s1-.95 1.25-1.5c.37-.81.7-1.51 1.17-2.26.96-1.53 2.21-2.85 3.16-4.4C18.5 12.37 19 10.74 19 9c0-3.87-3.13-7-7-7zm0 9.75a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('direccion.direccion')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="region">REGION:</label>
                <div class="relative">
                    <input type="text" placeholder="INGRESA UNA REGION" class="form-input w-full pl-9"
                        wire:model='direccion.region'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 1.74.5 3.37 1.41 4.84.95 1.54 2.2 2.86 3.16 4.4.47.75.81 1.45 1.17 2.26.26.55.47 1.5 1.26 1.5s1-.95 1.25-1.5c.37-.81.7-1.51 1.17-2.26.96-1.53 2.21-2.85 3.16-4.4C18.5 12.37 19 10.74 19 9c0-3.87-3.13-7-7-7zm0 9.75a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('direccion.region')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="provincia">PROVINCIA:</label>
                <div class="relative">
                    <input type="text" placeholder="INGRESA UNA PROVINCIA" class="form-input w-full pl-9"
                        wire:model='direccion.provincia'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 1.74.5 3.37 1.41 4.84.95 1.54 2.2 2.86 3.16 4.4.47.75.81 1.45 1.17 2.26.26.55.47 1.5 1.26 1.5s1-.95 1.25-1.5c.37-.81.7-1.51 1.17-2.26.96-1.53 2.21-2.85 3.16-4.4C18.5 12.37 19 10.74 19 9c0-3.87-3.13-7-7-7zm0 9.75a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('direccion.provincia')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="distrito">DISTRITO:</label>
                <div class="relative">
                    <input type="text" placeholder="INGRESA UN DISTRITO" class="form-input w-full pl-9"
                        wire:model='direccion.distrito'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M12 2C8.13 2 5 5.13 5 9c0 1.74.5 3.37 1.41 4.84.95 1.54 2.2 2.86 3.16 4.4.47.75.81 1.45 1.17 2.26.26.55.47 1.5 1.26 1.5s1-.95 1.25-1.5c.37-.81.7-1.51 1.17-2.26.96-1.53 2.21-2.85 3.16-4.4C18.5 12.37 19 10.74 19 9c0-3.87-3.13-7-7-7zm0 9.75a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('direccion.distrito')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.informacion.edit')
                <button type="button" wire:click.prevent="save"
                    class="btn cursor-pointer bg-emerald-500 hover:bg-emerald-600  text-white">
                    GUARDAR
                </button>
                @endcan



            </div>
            <!-- separador -->
            <div class="col-span-12">
                <div class="flex justify-between items-center" aria-hidden="true">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                    <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                        <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                    </div>
                    <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                </div>
            </div>


            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="usuario_sol_sunat">USUARIO SOL SUNAT:</label>
                <div class="relative">
                    <input type="text" class="form-input w-full pl-9" wire:model='sunat.usuario_sol_sunat'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                            <g fill="currentColor" stroke="currentColor" class="nc-icon-wrapper">
                                <path d="M38,39H26A18,18,0,0,0,8,57H8s9,4,24,4,24-4,24-4h0A18,18,0,0,0,38,39Z"
                                    fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10">
                                </path>
                                <path data-color="color-2"
                                    d="M19,17.067a13,13,0,1,1,26,0C45,24.283,39.18,32,32,32S19,24.283,19,17.067Z"
                                    fill="none" stroke-linecap="square" stroke-miterlimit="10"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('sunat.usuario_sol_sunat')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="clave_sol_sunat">CLAVE SOL SUNAT:</label>
                <div class="relative">
                    <input type="password" class="form-input w-full pl-9" wire:model='sunat.clave_sol_sunat'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path
                                    d="M38,23a1,1,0,0,1-.707-.293l-6-6a1,1,0,0,1,0-1.414l8-8a1,1,0,0,1,1.414,0l6,6a1,1,0,0,1,0,1.414l-2,2a1,1,0,0,1-1.414,0L41,14.414,38.414,17l2.293,2.293a1,1,0,0,1,0,1.414l-2,2A1,1,0,0,1,38,23Z"
                                    fill="#eba40a"></path>
                                <path
                                    d="M44.061,3.939a1.5,1.5,0,0,0-2.122,0L17.923,27.956a10.027,10.027,0,1,0,2.121,2.121L44.061,6.061A1.5,1.5,0,0,0,44.061,3.939ZM12,43a7,7,0,1,1,4.914-11.978c.011.012.014.027.025.039s.027.014.039.025A6.995,6.995,0,0,1,12,43Z"
                                    fill="#ffd764"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('sunat.clave_sol_sunat')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-12 sm:col-span-3">
                <label class="block text-sm font-medium mb-1" for="clave_certificado_cdt">CLAVE CERTIFICADO
                    CDT:</label>
                <div class="relative">
                    <input type="password" class="form-input w-full pl-9" wire:model='sunat.clave_certificado_cdt'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path
                                    d="M38,23a1,1,0,0,1-.707-.293l-6-6a1,1,0,0,1,0-1.414l8-8a1,1,0,0,1,1.414,0l6,6a1,1,0,0,1,0,1.414l-2,2a1,1,0,0,1-1.414,0L41,14.414,38.414,17l2.293,2.293a1,1,0,0,1,0,1.414l-2,2A1,1,0,0,1,38,23Z"
                                    fill="#eba40a"></path>
                                <path
                                    d="M44.061,3.939a1.5,1.5,0,0,0-2.122,0L17.923,27.956a10.027,10.027,0,1,0,2.121,2.121L44.061,6.061A1.5,1.5,0,0,0,44.061,3.939ZM12,43a7,7,0,1,1,4.914-11.978c.011.012.014.027.025.039s.027.014.039.025A6.995,6.995,0,0,1,12,43Z"
                                    fill="#ffd764"></path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('sunat.clave_certificado_cdt')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.sunat.edit')
                <button type="button" wire:click.prevent="saveSunat"
                    class="btn cursor-pointer bg-talentus-100 hover:bg-talentus-200  text-white">
                    GUARDAR
                </button>
                @endcan

            </div>
            <div class="col-span-12">
                <div class="flex justify-between items-center" aria-hidden="true">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                    <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                        <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                    </div>
                    <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">


            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="serie_factura">SERIE FACTURA:</label>
                <div class="relative">
                    <input type="text" placeholder="F001" class="form-input w-full pl-9" wire:model='series.factura'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.factura')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="series.boleta">SERIE BOLETA:</label>
                <div class="relative">
                    <input type="text" placeholder="B001" class="form-input w-full pl-9" wire:model='series.boleta'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.boleta')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="series.recibos">SERIE RECIBO:</label>
                <div class="relative">
                    <input type="text" placeholder="R001" class="form-input w-full pl-9" wire:model='series.recibo'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.recibo')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="series.nota_credito">SERIE NOTA DE CREDITO:</label>
                <div class="relative">
                    <input type="text" placeholder="FF001" class="form-input w-full pl-9"
                        wire:model='series.nota_credito'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.nota_credito')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="series.nota_debito">SERIE NOTA DE DEBITO:</label>
                <div class="relative">
                    <input type="text" placeholder="FF01" class="form-input w-full pl-9"
                        wire:model='series.nota_debito'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.nota_debito')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="col-span-10 sm:col-span-2">
                <label class="block text-sm font-medium mb-1" for="series.nota_debito">SERIE COTIZACION:</label>
                <div class="relative">
                    <input type="text" placeholder="PRE" class="form-input w-full pl-9" wire:model='series.cotizacion'>
                    <div class="absolute inset-0 right-auto flex items-center pointer-events-none">
                        <svg class="w-4 h-4 shrink-0 ml-3 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <g class="nc-icon-wrapper">
                                <path d="M46,4V42a4,4,0,0,1-4,4H6l4-14V4a2,2,0,0,1,2-2H44A2,2,0,0,1,46,4Z"
                                    fill="#e3e3e3"></path>
                                <path d="M38,13H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,21H32a1,1,0,0,1,0-2h6a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,29H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M38,37H18a1,1,0,0,1,0-2H38a1,1,0,0,1,0,2Z" fill="#aeaeae"></path>
                                <path d="M26,21H18a1,1,0,0,1-1-1V12a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1v8A1,1,0,0,1,26,21Z"
                                    fill="#3aace9"></path>
                                <path d="M6,46H6a4,4,0,0,0,4-4V27H3a1,1,0,0,0-1,1V42A4,4,0,0,0,6,46Z" fill="#aeaeae">
                                </path>
                            </g>
                        </svg>
                    </div>
                </div>
                @error('series.cotizacion')
                <p class="mt-2 peer-invalid:visible text-pink-600 text-sm">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="px-4 py-3 col-span-12 bg-white text-right sm:px-6">
                @can('admin.settings.plantilla.series.edit')
                <button type="button" wire:click.prevent="saveSeries"
                    class="btn cursor-pointer bg-indigo-500 hover:bg-indigo-600  text-white">
                    GUARDAR
                </button>
                @endcan


            </div>

            <div class="col-span-12">
                <div class="flex justify-between items-center" aria-hidden="true">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                    <div class="grow w-full h-5 bg-white flex flex-col justify-center">
                        <div class="h-px w-full border-t border-dashed border-slate-200"></div>
                    </div>
                    <svg class="w-5 h-5 fill-white rotate-180" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 20c5.523 0 10-4.477 10-10S5.523 0 0 0h20v20H0Z" />
                    </svg>
                </div>
            </div>

        </div>
        {{-- FORMULARIOS DE IMAGENES --}}
        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

            @livewire('admin.ajustes.plantilla.images.documentos', ['plantilla' => $plantilla], key('doc' .
            $plantilla->id))
            @livewire('admin.ajustes.plantilla.images.contrato', ['plantilla' => $plantilla], key('contrato' .
            $plantilla->id))
            @livewire('admin.ajustes.plantilla.images.logo', ['plantilla' => $plantilla], key('logo' . $plantilla->id))
            @livewire('admin.ajustes.plantilla.images.fav-icon', ['plantilla' => $plantilla], key('fav-icon' .
            $plantilla->id))
        </div>

        <div class="grid grid-cols-12 gap-4 mt-4 pt-4 pb-4 bg-white px-3 mb-2">

            @livewire('admin.ajustes.plantilla.images.banner', ['plantilla' => $plantilla], key('banner' .
            $plantilla->id))
            @livewire('admin.ajustes.plantilla.images.firma', ['plantilla' => $plantilla], key('firma' .
            $plantilla->id))


        </div>

    </div>

</div>

@push('modals')
@livewire('admin.ajustes.plantilla.del-images')
@endpush
