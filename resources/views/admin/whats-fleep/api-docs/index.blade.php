<x-admin-layout>
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Documentación de la API</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Endpoint base: <span
                    class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-xs">{{ $baseUrl }}</span>
            </p>
        </div>

        <div class="space-y-4">
            @foreach ($endpoints as $endpoint)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3 px-5 py-4 cursor-pointer" x-data="{ open: false }"
                        @click="open = !open">
                        <span @class([
                            'px-2.5 py-1 text-xs font-bold rounded uppercase',
                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' =>
                                $endpoint['method'] === 'GET',
                            'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' =>
                                $endpoint['method'] === 'POST',
                        ])>{{ $endpoint['method'] }}</span>
                        <span class="font-mono text-sm text-gray-700 dark:text-gray-200">{{ $endpoint['path'] }}</span>
                        <span
                            class="text-gray-500 dark:text-gray-400 text-sm ml-auto">{{ $endpoint['description'] }}</span>
                        <x-form.icon name="chevron-down" class="w-4 h-4 text-gray-400 transition-transform"
                            ::class="{ 'rotate-180': open }" />
                    </div>

                    <div x-show="open" x-cloak class="border-t border-gray-100 dark:border-gray-700 px-5 py-4">
                        @if (!empty($endpoint['params']))
                            <h4 class="text-xs font-semibold text-gray-500 uppercase mb-3">Parámetros</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="text-left text-gray-500 text-xs">
                                            <th class="pb-2 pr-4">Campo</th>
                                            <th class="pb-2 pr-4">Tipo</th>
                                            <th class="pb-2 pr-4">Requerido</th>
                                            <th class="pb-2">Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                                        @foreach ($endpoint['params'] as $param)
                                            <tr>
                                                <td
                                                    class="py-2 pr-4 font-mono text-xs text-blue-600 dark:text-blue-400">
                                                    {{ $param['name'] }}</td>
                                                <td class="py-2 pr-4 text-xs text-gray-500">{{ $param['type'] }}</td>
                                                <td class="py-2 pr-4 text-xs">
                                                    @if ($param['required'])
                                                        <span class="text-red-500 font-semibold">Sí</span>
                                                    @else
                                                        <span class="text-gray-400">No</span>
                                                    @endif
                                                </td>
                                                <td class="py-2 text-xs text-gray-600 dark:text-gray-300">
                                                    {{ $param['description'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if (!empty($endpoint['example']))
                            <h4 class="text-xs font-semibold text-gray-500 uppercase mt-4 mb-2">Ejemplo</h4>
                            <pre class="bg-gray-800 text-green-400 text-xs rounded-lg p-4 overflow-auto">{{ $endpoint['example'] }}</pre>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-admin-layout>
