<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }

        .talentus-gradient {
            background: linear-gradient(135deg, #060b34 0%, #0e2157 35%, #122f71 70%, #888989 100%);
        }
    </style>

    <div
        class="min-h-screen talentus-gradient flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-br from-white/5 to-transparent">
            </div>
        </div>

        <div class="w-full max-w-md relative z-10">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/logo-2-1.png') }}" alt="Talentus" class="h-16 w-auto">
            </div>

            <!-- Card Principal -->
            <x-form.card class="shadow-2xl border-0 bg-white/95 backdrop-blur-sm">
                <!-- Título -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-[#060b34] mb-2"
                        style="font-family: 'Montserrat', sans-serif; font-weight: 700;">
                        ¡Bienvenido a Talentus! ✨
                    </h1>
                    <p class="text-gray-600 text-sm" style="font-family: 'Montserrat', sans-serif;">
                        Ingresa tus credenciales para acceder al panel
                    </p>
                </div>

                @if (session('status'))
                    <x-form.alert class="mb-6" positive>
                        {{ session('status') }}
                    </x-form.alert>
                @endif

                <x-form.errors class="mb-6" />

                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <x-form.input label="Correo Electrónico" name="email" type="email"
                        placeholder="correo@ejemplo.com" value="{{ old('email') }}" required autofocus />

                    <!-- Password -->
                    <x-form.password label="Contraseña" name="password" placeholder="Ingresa tu contraseña" required
                        autocomplete="current-password" />

                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <x-form.checkbox id="remember_me" name="remember" label="Recuérdame" />

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-[#122f71] hover:text-[#0e2157] transition-colors">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- Botón de Login -->
                    <x-form.button type="submit" primary class="w-full bg-[#122f71] hover:bg-[#0e2157] border-0"
                        right-icon="arrow-right">
                        Iniciar Sesión
                    </x-form.button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Información</span>
                    </div>
                </div>

                <!-- Warning Footer -->
                <x-form.alert warning class="text-center">
                    <div class="flex items-center justify-center gap-2">
                        <x-form.icon name="shield-check" class="w-5 h-5" />
                        <span class="text-sm">
                            Panel exclusivo para administradores y personal autorizado
                        </span>
                    </div>
                </x-form.alert>
            </x-form.card>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-white/80" style="font-family: 'Montserrat', sans-serif;">
                    © {{ date('Y') }} Talentus. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
