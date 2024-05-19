@extends('layouts.admin')
@section('ruta', 'administracion-ajustes')
@section('panel', "settingsPanel: 'account',")
@section('contenido')

    <!-- Table -->

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full mx-auto">

        <!-- Page header -->
        <div class="mb-8">

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold"> Ajustes ✨</h1>

        </div>

        <div class="bg-white shadow-lg rounded-sm mb-8">
            <div class="flex flex-col md:flex-row md:-mr-px">

                <!-- Sidebar -->

                <x-admin.settings.navigation></x-admin.settings.navigation>

                <!-- Panel -->
                @livewire('admin.ajustes.cuenta.update-profile-information')
                {{-- <div class="grow">

                <!-- Panel body -->
                <div class="p-6 space-y-6">
                    <h2 class="text-2xl text-slate-800 font-bold mb-5">Mi Cuenta</h2>

                    <!-- Picture -->
                    <section>
                        <div class="flex items-center">
                            <div class="mr-4">
                                <img class="w-20 h-20 rounded-full" src="images/user-avatar-80.png" width="80"
                                    height="80" alt="User upload" />
                            </div>
                            <input type="file" class="hidden" wire:model.live="photo" x-ref="photo" x-on:change="
                                                                            photoName = $refs.photo.files[0].name;
                                                                            const reader = new FileReader();
                                                                            reader.onload = (e) => {
                                                                                photoPreview = e.target.result;
                                                                            };
                                                                            reader.readAsDataURL($refs.photo.files[0]);
                                                                    " />

                            <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Cambiar</button>
                        </div>
                    </section>

                    <!-- Business Profile -->
                    <section>
                        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">Perfil</h3>
                        <div class="text-sm">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                            officia deserunt mollit.</div>
                        <div class="sm:flex sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-5">
                            <div class="sm:w-1/3">
                                <label class="block text-sm font-medium mb-1" for="name">Nombre:</label>
                                <input id="name" class="form-input w-full" type="text" value="Acme Inc." />
                            </div>
                            <div class="sm:w-1/3">
                                <label class="block text-sm font-medium mb-1" for="business-id">Business
                                    ID</label>
                                <input id="business-id" class="form-input w-full" type="text" value="Kz4tSEqtUmA" />
                            </div>
                            <div class="sm:w-1/3">
                                <label class="block text-sm font-medium mb-1" for="location">Location</label>
                                <input id="location" class="form-input w-full" type="text" value="London, UK" />
                            </div>
                        </div>
                    </section>

                    <!-- Email -->
                    <section>
                        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">Email</h3>
                        <div class="text-sm">Excepteur sint occaecat cupidatat non proident sunt in culpa qui
                            officia.</div>
                        <div class="flex flex-wrap mt-5">
                            <div class="mr-2">
                                <label class="sr-only" for="email">Business email</label>
                                <input id="email" class="form-input" type="email" value="admin@acmeinc.com" />
                            </div>
                            <button
                                class="btn border-slate-200 hover:border-slate-300 shadow-sm text-indigo-500">Change</button>
                        </div>
                    </section>

                    <!-- Password -->
                    <section>
                        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">Password</h3>
                        <div class="text-sm">You can set a permanent password if you don't want to use temporary
                            login codes.</div>
                        <div class="mt-5">
                            <button class="btn border-slate-200 shadow-sm text-indigo-500">Set New
                                Password</button>
                        </div>
                    </section>

                    <!-- Smart Sync -->
                    <section>
                        <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">Smart Sync update for Mac
                        </h3>
                        <div class="flex items-center mt-5" x-data="{ checked: true }">
                            <div class="form-switch">
                                <input type="checkbox" id="toggle" class="sr-only" x-model="checked" />
                                <label class="bg-slate-400" for="toggle">
                                    <span class="bg-white shadow-sm" aria-hidden="true"></span>
                                    <span class="sr-only">Enable smart sync</span>
                                </label>
                            </div>
                            <div class="text-sm text-slate-400 italic ml-2" x-text="checked ? 'On' : 'Off'">
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Panel footer -->
                <footer>
                    <div class="flex flex-col px-6 py-5 border-t border-slate-200">
                        <div class="flex self-end">
                            <button class="btn border-slate-200 hover:border-slate-300 text-slate-600">Cancelar</button>
                            <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3">Guardar
                                Cambios</button>
                        </div>
                    </div>
                </footer>

            </div> --}}

            </div>
        </div>

    </div>


@stop
