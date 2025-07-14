<div>
    <!-- Formulario de consulta -->
    <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-700 mb-4">Consulta por Número de Placa</h4>

        <div class="space-y-4">
            <div>
                <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Número de Placa
                </label>
                <input type="text" wire:model="plate_number" id="plate_number"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Ej: T6G-611">
            </div>

            <!-- Mensajes de error -->
            @if ($error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $error }}
                </div>
            @endif

            <!-- Botones -->
            <div class="flex space-x-3">
                <button wire:click="consultarDispositivo" wire:loading.attr="disabled"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50">
                    <span wire:loading.remove>Consultar</span>
                    <span wire:loading>Consultando...</span>
                </button>

                <button wire:click="limpiar"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Limpiar
                </button>
            </div>
        </div>
    </div>

    <!-- Spinner de carga -->
    <div wire:loading class="flex justify-center items-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <span class="ml-2 text-gray-600">Buscando dispositivo...</span>
    </div>

    <!-- Resultados -->
    @if (!empty($devices) && !$loading)
        <div class="mt-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-1">
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h5 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Información del Vehículo
                        </h5>
                        <div class="text-sm text-gray-500">
                            Grupo: {{ $devices[0]['title'] }}
                        </div>
                    </div>

                    @foreach ($devices as $group)
                        @foreach ($group['items'] as $device)
                            <!-- Card principal del vehículo -->
                            <div
                                class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 overflow-hidden">

                                <!-- Header con placa y estado -->
                                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-white rounded-lg p-2">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-5H8z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-white">{{ $device['name'] }}</h3>
                                                <p class="text-blue-100 text-sm">Placa del vehículo</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $device['online'] == 'online' ? 'bg-green-100 text-green-800' : ($device['online'] == 'offline' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                <span
                                                    class="w-2 h-2 mr-2 rounded-full {{ $device['online'] == 'online' ? 'bg-green-400' : ($device['online'] == 'offline' ? 'bg-yellow-400' : 'bg-red-400') }}"></span>
                                                {{ ucfirst($device['online']) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenido principal -->
                                <div class="p-6">

                                    <!-- Información básica en cards -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                                        <!-- Card de Última Actualización -->
                                        <div
                                            class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-green-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-600">Última Actualización
                                                    </p>
                                                    <p class="text-lg font-semibold text-gray-900">{{ $device['time'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card de Icono del Dispositivo -->
                                        <div
                                            class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-purple-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-600">Icono del Dispositivo
                                                    </p>
                                                    <div class="flex items-center space-x-2 mt-1">
                                                        @if (isset($device['icon']['path']))
                                                            <img src="https://plataforma.talentustechnology.com/{{ $device['icon']['path'] }}"
                                                                alt="Icono del dispositivo"
                                                                class="h-8 w-auto object-contain"
                                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                            <span class="text-gray-500 text-sm hidden">Sin icono</span>
                                                        @else
                                                            <span class="text-gray-500 text-sm">Sin icono
                                                                disponible</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información del propietario -->
                                    @if (isset($device['device_data']))
                                        <div
                                            class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-5 border border-gray-200">
                                            <h6 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Datos del Propietario
                                            </h6>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <!-- Placa -->
                                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                    <p class="text-sm font-medium text-gray-600 mb-1">Número de Placa
                                                    </p>
                                                    <p class="text-lg font-bold text-blue-700">
                                                        {{ $device['device_data']['plate_number'] ?? 'No especificado' }}
                                                    </p>
                                                </div>

                                                <!-- Propietario -->
                                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                    <p class="text-sm font-medium text-gray-600 mb-1">Propietario</p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ $device['device_data']['object_owner'] ?? 'No especificado' }}
                                                    </p>
                                                </div>

                                                <!-- Tipo de Documento -->
                                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                                    <p class="text-sm font-medium text-gray-600 mb-1">Tipo de Documento
                                                    </p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ $device['device_data']['owner_tipo_documento'] ?? 'No especificado' }}
                                                    </p>
                                                </div>

                                                <!-- Número de Documento -->
                                                <div
                                                    class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
                                                    <p class="text-sm font-medium text-gray-600 mb-1">Número de
                                                        Documento</p>
                                                    <p class="text-lg font-semibold text-gray-900">
                                                        {{ $device['device_data']['owner_document_number'] ?? 'No especificado' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
