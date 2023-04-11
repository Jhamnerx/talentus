<x-guest-layout>
    <main class="bg-white">

        <div class="relative flex">

            <!-- Content -->
            <div class="w-full md:w-1/2">

                <div class="min-h-screen h-full flex flex-col after:flex-1">

                    <!-- Header -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                            <!-- Logo -->
                            <a class="block" href="{{ route('web.home') }}">

                                <img src="{{ asset('images/logo-2-1.png') }}" alt="">
                            </a>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="max-w-sm mx-auto px-4 py-8">

                        <h1 class="text-3xl text-slate-800 font-bold mb-6">BIENVENIDO A TALENTUS APP! ✨</h1>
                        <!-- Form -->
                        <x-jet-validation-errors class="mb-4" />
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <p tabindex="0"
                                class="focus:outline-none text-2xl font-extrabold leading-6 text-gray-800">
                                Ingresa en tu cuenta</p>


                            <button aria-label="Continue with google" role="button"
                                class="focus:outline-none hover:bg-slate-50 hover:border-gray-400 focus:ring-2 focus:ring-offset-1 focus:ring-gray-700 py-3.5 px-4 border rounded-lg border-gray-700 flex items-center w-full mt-10">
                                <img src="{{ asset('images/icons/google.svg') }}" alt="google">
                                <p class="text-base font-medium ml-4 text-gray-700">Ingresar con Google</p>
                            </button>
                            <button aria-label="Continue with facebook" role="button"
                                class="focus:outline-none hover:bg-slate-50 hover:border-gray-400 focus:ring-2 focus:ring-offset-1 focus:ring-gray-700 py-3.5 px-4 border rounded-lg border-gray-700 flex items-center w-full mt-4">
                                <img class="w-5 h-5" src="{{ asset('images/icons/facebook.svg') }}" alt="facebook">
                                <p class="text-base font-medium ml-4 text-gray-700">Ingresar con Facebook</p>
                            </button>

                            <div class="w-full flex items-center justify-between py-5">
                                <hr class="w-full bg-gray-400">
                                <p class="text-base font-medium leading-4 px-2.5 text-gray-400">O</p>
                                <hr class="w-full bg-gray-400  ">
                            </div>


                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1" for="email">Correo
                                        Electronico</label>
                                    <input id="email"
                                        class="w-full bg-gray-100 border rounded form-input text-xs font-medium leading-none text-gray-800 py-3 pl-3 mt-2"
                                        name="email" value="{{ old('email') }}" type="email" required autofocus />
                                </div>
                                <label class="block text-sm font-medium mb-1" for="password">Contraseña</label>
                                <div class="relative flex items-center justify-center">

                                    <input autocomplete="on" required autocomplete="current-password" id="password"
                                        type="password" name="password"
                                        class="bg-gray-200 border rounded form-input text-xs font-medium leading-none text-gray-800 py-3 w-full pl-3 mt-2" />
                                    <div class="absolute right-0 mt-2 mr-3 cursor-pointer">
                                        <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/sign_in-svg5.svg"
                                            alt="viewport">
                                    </div>
                                </div>
                                {{-- <div>
                                    <label class="block text-sm font-medium mb-1" for="empresa">Empresa:</label>
                                    <select class="form-select block mt-1 w-full" name="empresa" id="empresa" required>
                                        <option value="1">Talentus</option>
                                        <option value="2">Katary</option>
                                    </select>
                                </div> --}}
                            </div>
                            <div class="block mt-4">
                                <label for="remember_me" class="flex items-center">
                                    <x-jet-checkbox id="remember_me" name="remember" />
                                    <span class="ml-2 text-sm text-gray-600">Recuerdame</span>
                                </label>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <div class="mr-1">
                                    @if (Route::has('password.request'))
                                        <a class="text-sm underline hover:no-underline"
                                            href="{{ route('password.request') }}">Olvidaste tu
                                            Contraseña?</a>
                                    @endif
                                </div>

                                <x-jet-button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3">
                                    INGRESAR
                                </x-jet-button>
                            </div>

                        </form>



                        <!-- Footer -->
                        <div class="pt-5 mt-6 border-t border-slate-200">
                            {{-- <div class="text-sm">
                                No tienes una cuenta? <a class="font-medium text-indigo-500 hover:text-indigo-600"
                                    href="{{ route('register') }}">Registrate</a>
                            </div> --}}
                            <!-- Warning -->
                            <div class="mt-5">
                                <div class="bg-yellow-100 text-yellow-600 px-3 py-2 rounded">
                                    <svg class="inline w-3 h-3 shrink-0 fill-current" viewBox="0 0 12 12">
                                        <path
                                            d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                                    </svg>
                                    <span class="text-sm">
                                        Panel Disponible solo para administradores y personal
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Image -->
            <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
                <img class="object-cover object-center w-full h-full" src="images/auth-image.jpg" width="760"
                    height="1024" alt="Authentication image" />
                <img class="absolute top-1/4 left-0 transform -translate-x-1/2 ml-8 hidden lg:block"
                    src="images/auth-decoration-2.png" width="536" height="548" alt="Authentication decoration" />
            </div>
            {{-- <div class="block md:hidden absolute top-0 bottom-0 -z-10 right-0 md:w-1/2" aria-hidden="true">
                <img class="object-cover object-center bg-no-repeat w-full h-full" src="images/auth-mobile.jpg"
                    alt="Authentication image" />

            </div> --}}

        </div>

    </main>
</x-guest-layout>
