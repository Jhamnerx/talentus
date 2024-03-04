<div class="col-span-12 bg-white shadow-lg rounded-sm border border-slate-200">
    <div class="flex flex-col h-full">
        <!-- Card top -->
        <div class="grow p-5">
            <div class="flex justify-between items-start">
                <!-- Image + name -->
                <header>
                    <div class="flex mb-2">
                        <a class="relative inline-flex items-start mr-5" href="#0">

                            <img class="rounded-full" src="{{ asset('images/user-64-10.jpg') }}" width="64"
                                height="64" alt="User 01" />
                        </a>
                        <div class="mt-1 pr-1">
                            <a class="inline-flex text-slate-800 hover:text-slate-900" href="#0">
                                <h2 class="text-xl leading-snug justify-center font-semibold">
                                    {{ $cliente->razon_social }}</h2>
                            </a>
                            <div class="flex items-center"><span
                                    class="text-sm font-medium text-slate-400 -mt-0.5 mr-1">-&gt;</span>
                                <span>{{ $cliente->direccion }}</span>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="relative inline-flex shrink-0">
                    <button wire:click.prevent="unselectCliente" type="button"
                        class="text-slate-400 hover:text-slate-500 rounded-full"
                        :class="{ 'bg-slate-100 text-slate-500': open }" aria-haspopup="true">
                        <span class="sr-only">close</span>

                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="none" class="nc-icon-wrapper">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"
                                    fill="currentColor"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Bio -->
            <div class="mt-2">
                <div class="text-sm">DNI/RUC: {{ $cliente->numero_documento }}</div>
                <div class="text-sm">TELEFONO: {{ $cliente->telefono }}</div>
                <div class="text-sm">E-MAIL: {{ $cliente->email }}</div>
                <div class="text-sm">WEB: {{ $cliente->web_site }}</div>
            </div>
        </div>
        <!-- Card footer -->
        {{-- <div class="border-t border-slate-200">
            <div class="flex divide-x divide-slate-200r">
                <a class="block flex-1 text-center text-sm text-indigo-500 hover:text-indigo-600 font-medium px-3 py-4">
                    <div class="flex items-center justify-center">
                        <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.6 0 0 3.1 0 7s3.6 7 8 7h.6l5.4 2v-4.4c1.2-1.2 2-2.8 2-4.6 0-3.9-3.6-7-8-7zm4 10.8v2.3L8.9 12H8c-3.3 0-6-2.2-6-5s2.7-5 6-5 6 2.2 6 5c0 2.2-2 3.8-2 3.8z" />
                        </svg>
                        <span>Enviar Email</span>
                    </div>
                </a>
                <a
                    class="block flex-1 text-center text-sm text-slate-600 hover:text-slate-800 font-medium px-3 py-4 group">
                    <div class="flex items-center justify-center">
                        <svg class="w-4 h-4 fill-current text-slate-400 group-hover:text-slate-500 shrink-0 mr-2"
                            viewBox="0 0 16 16">
                            <path
                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z" />
                        </svg>
                        <span>Editar</span>
                    </div>
                </a>
            </div>
        </div> --}}
    </div>
</div>
