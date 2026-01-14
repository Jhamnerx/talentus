<x-form.modal.card title="SINCRONIZACIÓN GPSWOX → LOCAL" blur wire:model.live="openModal" align="start" max-width="6xl">

    <div>
        <!-- Barra de acciones -->
        <div
            class="flex flex-wrap gap-3 items-center mb-4 p-4 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-lg border border-blue-200 dark:border-gray-700">

            <!-- Botón principal de sincronización -->
            <div>
                <x-form.button wire:click="sincronizar" spinner="sincronizar" primary icon="arrow-path"
                    label="Sincronizar con GPSWox" lg />
            </div>

            <div class="flex-1"></div>

            <div class="text-xs text-gray-600 dark:text-gray-400">
                <span class="font-semibold">⚡ Actualización:</span> GPSWox → Sistema Local
            </div>
        </div>

        <!-- Panel de inconsistencias -->
        @if ($showComparison && count($mismatches) > 0)
            <div class="mb-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-lg p-4 shadow-sm">
                <div class="flex items-start mb-3">
                    <div class="shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-300">
                            ⚠️ {{ count($mismatches) }} Diferencias Detectadas
                        </h3>
                        <p class="text-sm text-yellow-700 dark:text-yellow-400 mt-1">
                            Sincroniza manualmente o usa el botón "Sincronizar Todo Automático" para aplicar todos los
                            cambios
                        </p>
                    </div>
                </div>

                <div class="space-y-3 max-h-[calc(100vh-300px)] overflow-y-auto pr-2">
                    @foreach ($mismatches as $mismatch)
                        <div
                            class="bg-white dark:bg-gray-800 border-2 {{ $mismatch['tipo'] === 'NO_EN_LOCAL' ? 'border-red-300 dark:border-red-700' : ($mismatch['tipo'] === 'REASIGNACION_GPSWOX_ID' ? 'border-purple-300 dark:border-purple-700' : 'border-yellow-300 dark:border-yellow-700') }} rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <!-- Encabezado -->
                                    <div class="flex items-center gap-2 mb-3">
                                        <p class="font-bold text-gray-900 dark:text-white text-xl">
                                            {{ $mismatch['placa'] }}
                                        </p>
                                        @if ($mismatch['tipo'] === 'NO_EN_LOCAL')
                                            <x-form.mini.badge negative label="NO EN LOCAL" />
                                        @elseif($mismatch['tipo'] === 'REASIGNACION_GPSWOX_ID')
                                            <x-form.mini.badge purple label="REASIGNACIÓN" />
                                        @elseif($mismatch['tipo'] === 'IMEI_DIFERENTE')
                                            <x-form.mini.badge amber label="IMEI" />
                                        @elseif($mismatch['tipo'] === 'SIM_DIFERENTE')
                                            <x-form.mini.badge warning label="SIM" />
                                        @endif
                                    </div>

                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 font-medium">
                                        {{ $mismatch['mensaje'] }}
                                    </p>

                                    <!-- CASO: No en local -->
                                    @if ($mismatch['tipo'] === 'NO_EN_LOCAL')
                                        <div
                                            class="bg-red-50 dark:bg-red-900/20 p-3 rounded-lg border border-red-200 dark:border-red-800">
                                            <p class="text-xs font-semibold text-red-800 dark:text-red-300 mb-2">
                                                🌐 Datos en GPSWox:
                                            </p>
                                            <div class="grid grid-cols-3 gap-2 text-xs">
                                                <div>
                                                    <span
                                                        class="text-red-600 dark:text-red-400 font-medium">IMEI:</span>
                                                    <p class="text-gray-700 dark:text-gray-300">
                                                        {{ $mismatch['api_imei'] }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-red-600 dark:text-red-400 font-medium">SIM:</span>
                                                    <p class="text-gray-700 dark:text-gray-300">
                                                        {{ $mismatch['api_sim'] }}</p>
                                                </div>
                                                <div>
                                                    <span
                                                        class="text-red-600 dark:text-red-400 font-medium">Modelo:</span>
                                                    <p class="text-gray-700 dark:text-gray-300">
                                                        {{ $mismatch['api_modelo'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- CASO: Reasignación GPSWox ID -->
                                    @if ($mismatch['tipo'] === 'REASIGNACION_GPSWOX_ID')
                                        <div
                                            class="bg-purple-50 dark:bg-purple-900/20 p-3 rounded-lg border border-purple-200 dark:border-purple-800">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1">
                                                    <p
                                                        class="text-xs font-semibold text-purple-800 dark:text-purple-300 mb-1">
                                                        📍 Placa Antigua:
                                                    </p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-bold">
                                                        {{ $mismatch['placa_antigua'] }}
                                                    </p>
                                                </div>
                                                <div class="text-purple-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p
                                                        class="text-xs font-semibold text-purple-800 dark:text-purple-300 mb-1">
                                                        📍 Placa Nueva:
                                                    </p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-bold">
                                                        {{ $mismatch['placa_nueva'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- CASO: IMEI Diferente -->
                                    @if ($mismatch['tipo'] === 'IMEI_DIFERENTE')
                                        <div
                                            class="grid grid-cols-2 gap-3 text-xs bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                            <div>
                                                <span class="font-semibold text-blue-600 dark:text-blue-400">💾 BD
                                                    Local:</span>
                                                <p class="text-gray-700 dark:text-gray-300 mt-1 font-mono">
                                                    {{ $mismatch['local_imei'] ?? 'Sin IMEI' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-green-600 dark:text-green-400">🌐
                                                    GPSWox:</span>
                                                <p class="text-gray-700 dark:text-gray-300 mt-1 font-mono">
                                                    {{ $mismatch['api_imei'] ?? 'Sin IMEI' }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- CASO: SIM Diferente -->
                                    @if ($mismatch['tipo'] === 'SIM_DIFERENTE')
                                        <div
                                            class="grid grid-cols-2 gap-3 text-xs bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                            <div>
                                                <span class="font-semibold text-blue-600 dark:text-blue-400">💾 BD
                                                    Local:</span>
                                                <p class="text-gray-700 dark:text-gray-300 mt-1 font-mono">
                                                    {{ $mismatch['local_sim'] ?? 'Sin SIM' }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-green-600 dark:text-green-400">🌐
                                                    GPSWox:</span>
                                                <p class="text-gray-700 dark:text-gray-300 mt-1 font-mono">
                                                    {{ $mismatch['api_sim'] ?? 'Sin SIM' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Botón de actualización individual -->
                                @if ($mismatch['tipo'] !== 'NO_EN_LOCAL')
                                    <div class="shrink-0">
                                        <x-form.button xs primary icon="arrow-down-tray"
                                            wire:click="actualizarDesdeGpswox('{{ $mismatch['placa'] }}')"
                                            spinner="actualizarDesdeGpswox" label="Sincronizar"
                                            title="Actualizar desde GPSWox" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($showComparison && count($mismatches) === 0)
            <div class="mb-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 rounded-lg p-5 shadow-sm">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-green-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-green-800 dark:text-green-300 font-bold text-lg">
                            ✓ Sincronización Perfecta
                        </p>
                        <p class="text-green-700 dark:text-green-400 text-sm">
                            Todos los dispositivos activos de GPSWox coinciden con la base de datos local
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if (!$showComparison)
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto mb-6 text-blue-300 dark:text-blue-700" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div class="space-y-3">
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                        Sincroniza tus dispositivos GPSWox
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        Haz clic en el botón superior <strong>"Sincronizar con GPSWox"</strong> para obtener los
                        dispositivos activos y compararlos con tu base de datos local
                    </p>
                    <div class="pt-4">
                        <x-form.button wire:click="sincronizar" spinner="sincronizar" primary icon="arrow-path"
                            label="Iniciar Sincronización" xl />
                    </div>
                </div>
            </div>
        @endif

    </div>

</x-form.modal.card>
