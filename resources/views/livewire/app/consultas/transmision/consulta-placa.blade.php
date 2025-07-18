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
        <div class="mt-6">
            @foreach ($devices as $group)
                @foreach ($group['items'] as $device)
                    <!-- Card principal del vehículo -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">

                        <!-- Header con placa y estado -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-3 sm:px-4 sm:py-4">
                            <div
                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                <div class="flex items-center space-x-2 min-w-0 flex-1">
                                    <div class="bg-white rounded p-1 flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-5H8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-base sm:text-xl font-bold text-white truncate">
                                            {{ $device['name'] }}</h3>
                                        <p class="text-blue-100 text-xs">Placa del vehículo</p>
                                    </div>
                                </div>
                                <div class="flex justify-center sm:justify-end flex-shrink-0">
                                    @php
                                        // Determinar el estado basado en la hora de transmisión y contenido
                                        $deviceStatus = 'desconectado';
                                        $statusColor = 'bg-red-500';
                                        $statusText = 'DESCONECTADO';
                                        $statusDot = 'bg-red-200';
                                        $animate = '';

                                        // Verificar si contiene texto "desactivado"
                                        if (stripos($device['time'], 'desactivado') !== false) {
                                            $deviceStatus = 'desactivado';
                                            $statusColor = 'bg-gray-500';
                                            $statusText = 'DESACTIVADO';
                                            $statusDot = 'bg-gray-200';
                                        } else {
                                            // Intentar parsear la fecha
                                            try {
                                                $transmissionTime = \Carbon\Carbon::parse($device['time']);
                                                $now = \Carbon\Carbon::now();
                                                $diffInHours = $now->diffInHours($transmissionTime);

                                                if ($diffInHours <= 24) {
                                                    // Menos de 24 horas = CONECTADO
                                                    $deviceStatus = 'conectado';
                                                    $statusColor = 'bg-green-500';
                                                    $statusText = 'CONECTADO';
                                                    $statusDot = 'bg-green-200';
                                                    $animate = 'animate-pulse';
                                                } elseif ($diffInHours <= 72) {
                                                    // Entre 1-3 días = SIN SEÑAL
                                                    $deviceStatus = 'sin_senal';
                                                    $statusColor = 'bg-yellow-500';
                                                    $statusText = 'SIN SEÑAL';
                                                    $statusDot = 'bg-yellow-200';
                                                }
                                                // Más de 3 días = DESCONECTADO (ya definido arriba)
                                            } catch (\Exception $e) {
                                                // Si no se puede parsear la fecha, mantener DESCONECTADO
                                            }
                                        }
                                    @endphp

                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }} text-white shadow {{ $animate }}">
                                        <div
                                            class="w-2 h-2 mr-1.5 rounded-full {{ $statusDot }} {{ $deviceStatus === 'conectado' ? 'animate-ping' : '' }}">
                                        </div>
                                        {{ $statusText }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido principal -->
                        <div class="p-3">
                            <!-- Información básica en cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                                <!-- Card de Última Actualización -->
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-6 h-6 bg-green-100 rounded flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-600 mb-0.5">Última Actualización</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $device['time'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card de Icono del Dispositivo -->
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-6 h-6 bg-purple-100 rounded flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-600 mb-0.5">Icono del Dispositivo
                                            </p>
                                            <div class="flex items-center">
                                                @if (isset($device['icon']['path']))
                                                    <img src="https://plataforma.talentustechnology.com/{{ $device['icon']['path'] }}"
                                                        alt="Icono del dispositivo" class="h-4 w-auto object-contain"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <span class="text-gray-500 text-xs hidden">Sin icono</span>
                                                @else
                                                    <span class="text-gray-500 text-xs">Sin icono disponible</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del propietario -->
                            @if (isset($device['device_data']))
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    <h6 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-600 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span class="truncate">Datos del Propietario</span>
                                    </h6>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        <!-- Placa -->
                                        <div class="bg-white rounded p-2 border border-gray-200">
                                            <p class="text-xs font-medium text-gray-600 mb-1">Número de Placa</p>
                                            <p class="text-sm font-bold text-blue-700 truncate">
                                                {{ $device['device_data']['plate_number'] ?? 'No especificado' }}
                                            </p>
                                        </div>

                                        <!-- Propietario -->
                                        <div class="bg-white rounded p-2 border border-gray-200">
                                            <p class="text-xs font-medium text-gray-600 mb-1">Propietario</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate"
                                                title="{{ $device['device_data']['object_owner'] ?? 'No especificado' }}">
                                                {{ $device['device_data']['object_owner'] ?? 'No especificado' }}
                                            </p>
                                        </div>

                                        <!-- Tipo de Documento -->
                                        <div class="bg-white rounded p-2 border border-gray-200">
                                            <p class="text-xs font-medium text-gray-600 mb-1">Tipo de Documento</p>
                                            <p class="text-sm font-semibold text-gray-900">
                                                {{ $device['device_data']['owner_tipo_documento'] ?? 'No especificado' }}
                                            </p>
                                        </div>

                                        <!-- Número de Documento -->
                                        <div class="bg-white rounded p-2 border border-gray-200">
                                            <p class="text-xs font-medium text-gray-600 mb-1">Número de Documento</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $device['device_data']['owner_document_number'] ?? 'No especificado' }}
                                            </p>
                                        </div>

                                        <!-- Última Acta -->
                                        @if (isset($device['device_data']['ultima_acta']) && $device['device_data']['ultima_acta'])
                                            <div class="bg-white rounded p-2 border border-gray-200 sm:col-span-2">
                                                <p class="text-xs font-medium text-gray-600 mb-1">Última Acta</p>
                                                <div class="space-y-2">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                                        <div>
                                                            <p class="text-sm font-semibold text-gray-900">
                                                                Nº
                                                                {{ $device['device_data']['ultima_acta']['numero'] }}
                                                            </p>
                                                            <p class="text-xs text-gray-600">
                                                                {{ $device['device_data']['ultima_acta']['fecha_creacion'] }}
                                                            </p>

                                                        </div>
                                                        <div>
                                                            <button
                                                                onclick="mostrarPDF({{ $device['device_data']['ultima_acta']['id'] }})"
                                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                                    </path>
                                                                </svg>
                                                                Ver PDF
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-white rounded p-2 border border-gray-200 sm:col-span-2">
                                                <p class="text-xs font-medium text-gray-600 mb-1">Última Acta</p>
                                                <p class="text-sm text-gray-500 italic">Sin actas registradas</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Información de Contratos -->
                            @if (isset($device['device_data']['contratos']))
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 mt-4">
                                    <h6 class="text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-600 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span class="truncate">Contratos del Vehículo</span>
                                        <span
                                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ count($device['device_data']['contratos']) }}
                                        </span>
                                    </h6>

                                    @if (count($device['device_data']['contratos']) > 0)
                                        <div class="space-y-3">
                                            @foreach ($device['device_data']['contratos'] as $contrato)
                                                <div
                                                    class="bg-white rounded-lg p-3 border border-gray-200 hover:shadow-md transition-shadow">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0">
                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-2 mb-2">
                                                                <h7 class="text-sm font-semibold text-gray-900">
                                                                    Contrato Nº {{ $contrato['numero'] }}
                                                                </h7>
                                                                @if ($contrato['estado'])
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                                        {{ $contrato['estado'] === 'activo'
                                                                            ? 'bg-green-100 text-green-800'
                                                                            : ($contrato['estado'] === 'vencido'
                                                                                ? 'bg-red-100 text-red-800'
                                                                                : 'bg-gray-100 text-gray-800') }}">
                                                                        {{ ucfirst($contrato['estado']) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs text-gray-600">
                                                                <div>
                                                                    <span class="font-medium">Inicio:</span>
                                                                    {{ $contrato['fecha_inicio'] }}
                                                                </div>
                                                                <div>
                                                                    <span class="font-medium">Fin:</span>
                                                                    {{ $contrato['fecha_fin'] }}
                                                                </div>
                                                                @if ($contrato['tipo'] && $contrato['tipo'] !== 'N/A')
                                                                    <div>
                                                                        <span class="font-medium">Tipo:</span>
                                                                        {{ $contrato['tipo'] }}
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        <div class="flex space-x-2">
                                                            <button
                                                                onclick="mostrarContratoPDF('{{ $contrato['unique_hash'] }}')"
                                                                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2"
                                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                                    </path>
                                                                </svg>
                                                                Ver Contrato
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="bg-white rounded p-3 border border-gray-200">
                                            <p class="text-sm text-gray-500 italic text-center">No hay contratos
                                                registrados para este vehículo</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @endif

    <!-- Modal para mostrar PDF -->
    <div id="pdfModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 items-center justify-center p-4"
        style="display: none;">
        <div class="bg-white rounded-lg w-full max-w-5xl h-4/5 max-h-[80vh] flex flex-col shadow-2xl mx-auto my-auto">
            <!-- Header del modal -->
            <div class="flex justify-between items-center p-4 border-b bg-gray-50 rounded-t-lg flex-shrink-0">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Documento</h3>
                </div>
                <button onclick="cerrarPDF()"
                    class="text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full p-1 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del modal -->
            <div class="flex-1 p-4 bg-gray-100 rounded-b-lg overflow-hidden">
                <div class="w-full h-full bg-white rounded shadow-inner">
                    <iframe id="pdfFrame" src="" class="w-full h-full border-0 rounded">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarPDF(actaId) {
            // Construir la URL del PDF usando la nueva ruta
            const pdfUrl = `/consulta/acta-pdf/${actaId}`;

            // Cambiar el título del modal
            document.getElementById('modalTitle').textContent = 'Acta de Instalación';

            // Establecer la URL en el iframe
            document.getElementById('pdfFrame').src = pdfUrl;

            // Mostrar el modal
            const modal = document.getElementById('pdfModal');
            modal.style.display = 'flex';
        }

        function mostrarContratoPDF(contratoHash) {
            // Construir la URL del contrato PDF usando unique_hash
            const pdfUrl = `/admin/pdf/contratos/${contratoHash}`;

            // Cambiar el título del modal
            document.getElementById('modalTitle').textContent = 'Contrato de Servicio';

            // Establecer la URL en el iframe
            document.getElementById('pdfFrame').src = pdfUrl;

            // Mostrar el modal
            const modal = document.getElementById('pdfModal');
            modal.style.display = 'flex';
        }

        function cerrarPDF() {
            // Ocultar el modal
            const modal = document.getElementById('pdfModal');
            modal.style.display = 'none';

            // Limpiar el iframe
            document.getElementById('pdfFrame').src = '';
        }

        // Cerrar modal al hacer clic fuera del contenido
        document.getElementById('pdfModal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarPDF();
            }
        });

        // Cerrar modal con la tecla Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarPDF();
            }
        });
    </script>
</div>
