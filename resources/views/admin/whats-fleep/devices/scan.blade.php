<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">

        {{-- Page header --}}
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <a href="{{ route('admin.whats-fleep.devices') }}"
                    class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-200 mb-2">
                    <svg class="w-4 h-4 mr-1 fill-current" viewBox="0 0 16 16">
                        <path d="M9.4 13.4l1.4-1.4-3.4-3.4 3.4-3.4-1.4-1.4L5 8.6z" />
                    </svg>
                    Volver a dispositivos
                </a>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                    Conectar dispositivo: {{ $device->body }}
                </h1>
            </div>
        </div>

        {{-- Info banner --}}
        <div
            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-sm p-4 text-blue-700 dark:text-blue-300 text-sm flex items-center gap-2 mb-6">
            <svg class="w-5 h-5 shrink-0 fill-current" viewBox="0 0 16 16">
                <path
                    d="M8 1C4.1 1 1 4.1 1 8s3.1 7 7 7 7-3.1 7-7-3.1-7-7-7zm0 11c-.6 0-1-.4-1-1v-3c0-.6.4-1 1-1s1 .4 1 1v3c0 .6-.4 1-1 1zm0-6c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1z" />
            </svg>
            Escanea el código QR con tu app de WhatsApp para vincular el dispositivo.
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- QR Code card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                        Cuenta WhatsApp {{ $device->body }}
                    </h2>
                    <button id="logout-btn" onclick="logoutDevice('{{ $device->body }}')"
                        class="hidden px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer">
                        <span id="logout-text">Cerrar sesión</span>
                        <span id="logout-spinner"
                            class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin ml-2"></span>
                    </button>
                </div>
                <div>
                    <div
                        class="flex items-center justify-center bg-gray-50 dark:bg-gray-900/20 rounded-lg p-8 min-h-100">
                        <div id="qr-container" class="flex flex-col items-center w-full">
                            <div id="image-container" class="text-center flex items-center justify-center"
                                style="height:280px">
                                <div
                                    class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                                </div>
                            </div>
                            <div id="status-container" class="mt-6 w-full">
                                <button class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg" type="button"
                                    disabled>
                                    <span
                                        class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></span>
                                    Esperando al servidor Node.js...
                                </button>
                            </div>
                            <div id="connected-alert" class="mt-4 w-full hidden">
                                <div
                                    class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 flex items-center justify-center">
                                    <span class="font-semibold">Dispositivo conectado</span>
                                    <img src="{{ asset('firework.png') }}" alt="" class="ml-2 h-6">
                                </div>
                            </div>
                            <div id="action-buttons" class="mt-6 w-full hidden">
                                <div class="grid grid-cols-2 gap-4">
                                    <a href="{{ route('admin.whats-fleep.devices') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M5 4a3 3 0 100 6 3 3 0 000-6zm-4.5 9a4.5 4.5 0 019 0H.5zM16 5h-3V3h-1v2h-3v1h3v2h1V6h3V5z" />
                                        </svg>
                                        Mis dispositivos
                                    </a>
                                    <a href="{{ route('admin.whats-fleep.contacts') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M7 8a3 3 0 100-6 3 3 0 000 6zm2.9 1.1c-.8-.4-1.8-.6-2.9-.6-2.7 0-5 1.7-5 4v1h10v-1c0-2.3-2.3-4-5-4H7z" />
                                        </svg>
                                        Contactos
                                    </a>
                                    <a href="{{ route('admin.whats-fleep.messages.test') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M15 2H1a1 1 0 00-1 1v9a1 1 0 001 1h5l2 3 2-3h5a1 1 0 001-1V3a1 1 0 00-1-1z" />
                                        </svg>
                                        Enviar mensaje
                                    </a>
                                    <a href="{{ route('admin.whats-fleep.campaigns') }}"
                                        class="flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M13.5 7L15 5.5 13 3.5 11.5 5l2 2zm-4 4l2-2-2-2-2 2 2 2zM1 13h4v-4L1 5v8z" />
                                        </svg>
                                        Campañas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Account info & instructions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                        WhatsApp Info
                        <span
                            class="ml-2 text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">Updated
                            now</span>
                    </h2>
                </div>

                <div id="account-info">
                    <ul class="space-y-3">
                        <li class="p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg" id="account-name">
                            <span class="text-gray-600 dark:text-gray-400">Nombre:</span>
                            <span class="text-gray-800 dark:text-gray-200 ml-2">—</span>
                        </li>
                        <li class="p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg" id="account-number">
                            <span class="text-gray-600 dark:text-gray-400">Número:</span>
                            <span class="text-gray-800 dark:text-gray-200 ml-2">—</span>
                        </li>
                        <li class="p-3 bg-gray-50 dark:bg-gray-900/20 rounded-lg" id="account-device">
                            <span class="text-gray-600 dark:text-gray-400">Token:</span>
                            <span class="text-gray-800 dark:text-gray-200 ml-2">{{ $device->body }}</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-8">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-4">¿Cómo escanear?</h3>

                    <div class="mb-6 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900/20">
                        <img src="{{ asset('images/scan-demo.gif') }}" alt="Scan Demo" class="w-full h-auto">
                    </div>

                    <div class="space-y-4">
                        @foreach (['Abre WhatsApp en tu teléfono', 'Ve a Menú y selecciona Dispositivos vinculados', 'Toca "Vincular un dispositivo"', 'Apunta la cámara al código QR de la pantalla'] as $i => $step)
                            <div class="flex items-start gap-3">
                                <div
                                    class="shrink-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-semibold">
                                    {{ $i + 1 }}
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 text-sm pt-1">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="{{ config('whatsapp.socket_url', 'http://localhost:3000') }}/socket.io/socket.io.js"></script>
        <script>
            let socket;
            let device = '{{ $device->body }}';
            let sessionConnected = false;

            socket = io('{{ config('whatsapp.socket_url', 'http://localhost:3000') }}', {
                transports: ['websocket', 'polling', 'flashsocket']
            });

            socket.on('connect', () => {
                socket.emit('StartConnection', device);
            });

            socket.on('qrcode', ({
                token,
                data,
                message
            }) => {
                if (token == device && !sessionConnected) {
                    document.getElementById('image-container').innerHTML =
                        `<img src="${data}" height="300" alt="QR Code" class="mx-auto rounded-lg">`;
                    document.getElementById('status-container').innerHTML =
                        `<button class="w-full px-4 py-3 bg-yellow-600 text-white rounded-lg" type="button" disabled>${message}</button>`;
                }
            });

            socket.on('connection-open', ({
                token,
                user,
                ppUrl
            }) => {
                if (token == device) {
                    sessionConnected = true;

                    document.getElementById('account-name').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Nombre:</span>
                        <span class="text-slate-700 dark:text-gray-200 ml-2 font-semibold">${user?.name || '—'}</span>`;
                    document.getElementById('account-number').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Número:</span>
                        <span class="text-slate-700 dark:text-gray-200 ml-2 font-semibold">${user?.id || '—'}</span>`;
                    document.getElementById('image-container').innerHTML =
                        `<img src="${ppUrl || ''}" alt="Profile" class="mx-auto rounded-full w-48 h-48 object-cover border-4 border-green-500">`;

                    document.getElementById('status-container').classList.add('hidden');
                    document.getElementById('connected-alert').classList.remove('hidden');
                    document.getElementById('action-buttons').classList.remove('hidden');

                    // Reset logout button
                    document.getElementById('logout-text').textContent = 'Cerrar sesión';
                    document.getElementById('logout-spinner').style.display = 'none';
                    document.getElementById('logout-btn').disabled = false;
                    document.getElementById('logout-btn').classList.remove('opacity-75', 'cursor-not-allowed');
                    document.getElementById('logout-btn').classList.remove('hidden');
                }
            });

            socket.on('Unauthorized', ({
                token
            }) => {
                if (token == device) {
                    document.getElementById('status-container').innerHTML =
                        `<button class="w-full px-4 py-3 bg-red-600 text-white rounded-lg" type="button" disabled>No autorizado</button>`;
                }
            });

            socket.on('message', ({
                token,
                message
            }) => {
                if (token == device) {
                    document.getElementById('status-container').innerHTML =
                        `<button class="w-full px-4 py-3 bg-green-600 text-white rounded-lg" type="button" disabled>${message}</button>`;

                    if (message.includes('Connection closed')) {
                        let count = 5;
                        let interval = setInterval(() => {
                            if (count === 0) {
                                clearInterval(interval);
                                location.reload();
                            }
                            document.getElementById('status-container').innerHTML =
                                `<button class="w-full px-4 py-3 bg-yellow-600 text-white rounded-lg" type="button" disabled>${message} en ${count}s...</button>`;
                            count--;
                        }, 1000);
                    }
                }
            });

            socket.on('logged-out', ({
                token,
                message,
                requiresManualReconnect
            }) => {
                if (token == device) {
                    sessionConnected = false;

                    ['connected-alert', 'action-buttons', 'logout-btn'].forEach(id =>
                        document.getElementById(id).classList.add('hidden'));

                    // Reset account info
                    document.getElementById('account-name').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Nombre:</span><span class="ml-1 text-slate-700 dark:text-gray-200">—</span>`;
                    document.getElementById('account-number').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Número:</span><span class="ml-1 text-slate-700 dark:text-gray-200">—</span>`;

                    if (requiresManualReconnect) {
                        document.getElementById('image-container').innerHTML =
                            `<div class="flex flex-col items-center justify-center text-center">
                                <svg class="w-16 h-16 text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <p class="text-sm text-slate-500 dark:text-gray-400 mb-1">WhatsApp rechazó la conexión</p>
                                <p class="text-xs text-slate-400 dark:text-gray-500">Espera unos segundos antes de reintentar</p>
                            </div>`;
                        document.getElementById('status-container').classList.remove('hidden');
                        document.getElementById('status-container').innerHTML =
                            `<button onclick="requestNewQR()" class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded transition cursor-pointer text-sm">
                                <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reintentar / Obtener QR
                            </button>`;
                    } else {
                        document.getElementById('image-container').innerHTML =
                            `<div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>`;
                        document.getElementById('status-container').classList.remove('hidden');
                        document.getElementById('status-container').innerHTML =
                            `<button class="w-full px-4 py-3 bg-yellow-600 text-white rounded text-sm" type="button" disabled>${message}</button>`;
                    }
                }
            });

            function requestNewQR() {
                document.getElementById('image-container').innerHTML =
                    `<div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>`;
                document.getElementById('status-container').innerHTML =
                    `<button class="w-full px-4 py-3 bg-blue-600 text-white rounded text-sm" type="button" disabled>
                        <span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></span>
                        Solicitando QR...
                    </button>`;
                socket.emit('StartConnection', device);
            }

            function logoutDevice(device) {
                document.getElementById('logout-text').textContent = 'Cerrando sesión...';
                document.getElementById('logout-spinner').style.display = 'inline-block';
                document.getElementById('logout-btn').disabled = true;
                document.getElementById('logout-btn').classList.add('opacity-75', 'cursor-not-allowed');

                socket.emit('LogoutDevice', device);

                setTimeout(() => {
                    ['connected-alert', 'action-buttons', 'logout-btn'].forEach(id =>
                        document.getElementById(id).classList.add('hidden'));

                    document.getElementById('image-container').innerHTML =
                        `<div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>`;
                    document.getElementById('status-container').classList.remove('hidden');
                    document.getElementById('status-container').innerHTML =
                        `<button class="w-full px-4 py-3 bg-blue-600 text-white rounded text-sm" type="button" disabled>
                            <span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></span>
                            Esperando al servidor Node.js...
                        </button>`;

                    document.getElementById('account-name').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Nombre:</span><span class="ml-1 text-slate-700 dark:text-gray-200">—</span>`;
                    document.getElementById('account-number').innerHTML =
                        `<span class="text-slate-500 dark:text-gray-400">Número:</span><span class="ml-1 text-slate-700 dark:text-gray-200">—</span>`;

                    document.getElementById('logout-text').textContent = 'Cerrar sesión';
                    document.getElementById('logout-spinner').style.display = 'none';
                    document.getElementById('logout-btn').disabled = false;
                    document.getElementById('logout-btn').classList.remove('opacity-75', 'cursor-not-allowed');

                    socket.emit('StartConnection', device);
                }, 2000);
            }
        </script>
    @endpush
</x-admin-layout>
