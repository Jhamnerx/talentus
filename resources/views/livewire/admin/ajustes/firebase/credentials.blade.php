<div>

    {{-- Encabezado --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Credenciales Firebase (FCM)</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Sube el archivo <span class="font-mono">service-account.json</span> de tu proyecto Firebase para enviar
            notificaciones push al app de los técnicos.
        </p>
    </div>

    {{-- Estado actual --}}
    <div class="bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        @if ($existe)
            <div class="flex items-start gap-3">
                <span class="shrink-0 w-9 h-9 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Firebase configurado</p>
                    <dl class="mt-2 text-xs space-y-1">
                        <div class="flex gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 w-24 shrink-0">Proyecto</dt>
                            <dd class="font-mono text-gray-700 dark:text-gray-300">{{ $projectId ?? '—' }}</dd>
                        </div>
                        <div class="flex gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 w-24 shrink-0">Cuenta</dt>
                            <dd class="font-mono text-gray-700 dark:text-gray-300 truncate">{{ $clientEmail ?? '—' }}</dd>
                        </div>
                        <div class="flex gap-2">
                            <dt class="text-gray-400 dark:text-gray-500 w-24 shrink-0">Actualizado</dt>
                            <dd class="text-gray-700 dark:text-gray-300">{{ $actualizadoEn ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        @else
            <div class="flex items-start gap-3">
                <span class="shrink-0 w-9 h-9 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Sin credenciales</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Aún no se ha subido el archivo. Las notificaciones push no se enviarán hasta configurarlo.
                    </p>
                </div>
            </div>
        @endif
    </div>

    {{-- Formulario de subida --}}
    <div class="bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-5">
        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            {{ $existe ? 'Reemplazar archivo de credenciales' : 'Subir archivo de credenciales' }}
        </p>

        <input type="file" wire:model="file" accept=".json,application/json"
            class="block w-full text-sm text-gray-600 dark:text-gray-300
                   file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                   file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600
                   hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300
                   cursor-pointer" />

        @error('file')
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror

        <div wire:loading wire:target="file" class="mt-2 text-xs text-gray-400">Cargando archivo…</div>

        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
            Se guarda en <span class="font-mono">storage/app/firebase/firebase-credentials.json</span>.
            Genéralo en <span class="font-medium">Firebase → Configuración del proyecto → Cuentas de servicio → Generar nueva clave privada</span>.
        </p>

        <div class="flex justify-end mt-4">
            <x-form.button primary label="Guardar credenciales" wire:click="save" spinner="save"
                wire:loading.attr="disabled" wire:target="save,file" />
        </div>
    </div>

    {{-- Prueba de notificación (solo si hay credenciales y hay usuarios con token) --}}
    @if ($existe)
        <div class="bg-gray-50 dark:bg-gray-700/40 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Enviar notificación de prueba</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Selecciona un usuario con token FCM registrado para verificar que la configuración es correcta.
            </p>

            @if ($usuariosConToken->isEmpty())
                <p class="text-xs text-amber-600 dark:text-amber-400">
                    No hay usuarios con token FCM registrado. Los técnicos registran su token al iniciar sesión en la app.
                </p>
            @else
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <select wire:model="usuarioPruebaId"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                                   bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200
                                   px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">— Selecciona un usuario —</option>
                            @foreach ($usuariosConToken as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                        @error('usuarioPruebaId')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.button
                        label="Enviar prueba"
                        wire:click="enviarPrueba"
                        spinner="enviarPrueba"
                        wire:loading.attr="disabled"
                        wire:target="enviarPrueba"
                        class="shrink-0"
                    />
                </div>
            @endif
        </div>
    @endif

</div>
