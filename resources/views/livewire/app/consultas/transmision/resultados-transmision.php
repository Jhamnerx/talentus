<div>
    <div class="mb-4">
        <h6 class="py-2 w-full leading-4 text-gray-600 dark:text-gray-300 font-semibold">
            RESULTADOS
        </h6>
    </div>

    @if(empty($devices))
    <div class="text-center py-8">
        <div class="text-gray-400 text-5xl mb-4">
            🔍
        </div>
        <p class="text-gray-500">Ingrese un número de placa para realizar la búsqueda</p>
    </div>
    @else
    <div class="space-y-4 max-h-96 overflow-y-auto">
        @foreach($devices as $group)
        @foreach($group['items'] as $device)
        <div class="border rounded-lg p-4 bg-gray-50">
            <!-- Encabezado del dispositivo -->
            <div class="flex items-center justify-between mb-3">
                <h6 class="font-semibold text-gray-800">{{ $device['name'] }}</h6>
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $device['online'] == 'online' ? 'bg-green-100 text-green-800' : ($device['online'] == 'offline' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst($device['online']) }}
                </span>
            </div>

            <!-- Información resumida -->
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Placa:</span>
                    <span class="font-medium">{{ $device['device_data']['plate_number'] ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Modelo:</span>
                    <span class="font-medium">{{ $device['device_data']['device_model'] ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Velocidad:</span>
                    <span class="font-medium">{{ $device['speed'] }} {{ $device['distance_unit_hour'] }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Última actualización:</span>
                    <span class="font-medium text-xs">{{ $device['time'] }}</span>
                </div>

                @if(isset($device['stop_duration']))
                <div class="flex justify-between">
                    <span class="text-gray-600">Tiempo detenido:</span>
                    <span class="font-medium text-xs">{{ $device['stop_duration'] }}</span>
                </div>
                @endif
            </div>

            <!-- Sensores principales (solo los más importantes) -->
            @if(!empty($device['sensors']))
            <div class="mt-3 pt-3 border-t border-gray-200">
                <h6 class="text-xs font-medium text-gray-600 mb-2">SENSORES PRINCIPALES</h6>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    @foreach(array_slice($device['sensors'], 0, 4) as $sensor)
                    @if(in_array($sensor['type'], ['battery', 'engine', 'odometer', 'fuel_consumption']))
                    <div class="bg-white p-2 rounded">
                        <div class="text-gray-600">{{ $sensor['name'] }}</div>
                        <div class="font-medium">{{ $sensor['value'] }}</div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Ubicación -->
            <div class="mt-3 pt-3 border-t border-gray-200">
                <h6 class="text-xs font-medium text-gray-600 mb-2">UBICACIÓN</h6>
                <div class="text-xs space-y-1">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Lat:</span>
                        <span class="font-mono">{{ $device['lat'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Lng:</span>
                        <span class="font-mono">{{ $device['lng'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endforeach
    </div>
    @endif
</div>