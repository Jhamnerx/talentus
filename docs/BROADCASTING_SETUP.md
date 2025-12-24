# Configuración de Laravel Echo (Broadcasting)

## Instalación

### 1. Instalar Pusher PHP SDK

```bash
composer require pusher/pusher-php-server
```

### 2. Instalar Laravel Echo y Pusher JS en Frontend

```bash
npm install --save-dev laravel-echo pusher-js
```

## Configuración Backend

### 1. Configurar Broadcasting (`config/broadcasting.php`)

Ya viene configurado por defecto con Pusher. Verificar:

```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
        'port' => env('PUSHER_PORT', 443),
        'scheme' => env('PUSHER_SCHEME', 'https'),
        'encrypted' => true,
        'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
    ],
],
```

### 2. Variables de Entorno (.env)

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1

# Para desarrollo local con Reverb (Laravel 11+) o Soketi
# PUSHER_HOST=127.0.0.1
# PUSHER_PORT=6001
# PUSHER_SCHEME=http
```

### 3. Descomentar BroadcastServiceProvider

En `config/app.php` (Laravel 10) o `bootstrap/providers.php` (Laravel 11), asegurarse que esté activo:

```php
App\Providers\BroadcastServiceProvider::class,
```

### 4. Configurar Canales de Broadcasting (`routes/channels.php`)

```php
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// Canal privado por usuario
Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    return (int) $user->id === (int) $userId;
});

// Canal privado por empresa
Broadcast::channel('empresa.{empresaId}', function (User $user, int $empresaId) {
    return (int) $user->empresa_id === (int) $empresaId;
});
```

## Configuración Frontend (Blade + Livewire)

### 1. Importar Echo en `resources/js/app.js`

```javascript
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? "mt1",
    wsHost:
        import.meta.env.VITE_PUSHER_HOST ??
        `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
    auth: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    },
});
```

### 2. Variables de Entorno Frontend (`.env` para Vite)

Asegurarse de que existan:

```env
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### 3. Compilar Assets

```bash
npm run build
# o para desarrollo
npm run dev
```

## Escuchar Eventos en Frontend

### Opción A: En un componente Livewire

```php
// app/Livewire/Admin/WorkOrders/Index.php

use Livewire\Attributes\On;

#[On('echo-private:user.{userId},work-order.created')]
public function handleWorkOrderCreated($event)
{
    $this->dispatch('notify-toast', [
        'icon' => 'success',
        'title' => 'Nueva Orden',
        'mensaje' => 'Se creó la orden ' . $event['codigo']
    ]);

    // Refrescar la tabla
    $this->dispatch('$refresh');
}
```

### Opción B: En JavaScript/Blade

```blade
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Escuchar en canal privado del usuario
    Echo.private('user.{{ auth()->id() }}')
        .listen('.work-order.created', (e) => {
            console.log('Nueva orden creada:', e);

            // Mostrar notificación
            window.$wireui.notify({
                title: '🔧 Nueva Orden',
                description: `Orden ${e.codigo} asignada`,
                icon: 'success'
            });

            // Actualizar componente Livewire
            Livewire.dispatch('work-order-created', e);
        })
        .listen('.work-order.updated', (e) => {
            console.log('Orden actualizada:', e);

            window.$wireui.notify({
                title: 'Orden Actualizada',
                description: `Estado: ${e.estado}`,
                icon: 'info'
            });

            Livewire.dispatch('work-order-updated', e);
        });

    // Escuchar en canal de empresa
    Echo.private('empresa.{{ session('empresa') }}')
        .listen('.work-order.created', (e) => {
            console.log('Nueva orden en empresa:', e);
        });
});
</script>
```

## Configuración con Pusher.com (Producción)

### 1. Crear Cuenta en Pusher

1. Ve a [pusher.com](https://pusher.com)
2. Crea una cuenta gratuita (100 conexiones concurrentes, 200k mensajes/día)
3. Crea una nueva app/channel
4. Copia las credenciales

### 2. Configurar en `.env`

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=1234567
PUSHER_APP_KEY=abcdef123456
PUSHER_APP_SECRET=xyz789secret
PUSHER_APP_CLUSTER=us2

# NO usar PUSHER_HOST, PUSHER_PORT, PUSHER_SCHEME
# para conectar directamente a Pusher.com
```

## Alternativa: Laravel Reverb (Laravel 11+)

Laravel Reverb es un servidor WebSocket de primera parte incluido en Laravel 11+.

### 1. Instalar Reverb

```bash
php artisan install:broadcasting
```

### 2. Configurar `.env`

```env
BROADCAST_DRIVER=reverb

REVERB_APP_ID=local
REVERB_APP_KEY=local
REVERB_APP_SECRET=local
REVERB_HOST="localhost"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

### 3. Iniciar Servidor Reverb

```bash
php artisan reverb:start
```

### 4. Configurar Frontend

```javascript
// resources/js/app.js
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
    enabledTransports: ["ws", "wss"],
});
```

## Alternativa: Soketi (Open Source, Self-Hosted)

Soketi es compatible con Pusher y gratuito.

### 1. Instalar Soketi

```bash
npm install -g @soketi/soketi
```

### 2. Iniciar Soketi

```bash
soketi start
```

O con configuración custom:

```bash
soketi start --config=soketi.config.json
```

```json
// soketi.config.json
{
    "debug": true,
    "port": 6001,
    "appManager.array.apps": [
        {
            "id": "local",
            "key": "local-key",
            "secret": "local-secret",
            "maxConnections": 100,
            "enableClientMessages": true,
            "enabled": true,
            "maxBackendEventsPerSecond": 100,
            "maxClientEventsPerSecond": 100,
            "maxReadRequestsPerSecond": 100
        }
    ]
}
```

### 3. Configurar `.env`

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local-key
PUSHER_APP_SECRET=local-secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Testing

### Probar Broadcasting desde Tinker

```php
php artisan tinker

$workOrder = WorkOrder::first();
event(new \App\Events\WorkOrderCreated($workOrder));
```

### Debug en el navegador

Abrir consola del navegador y verificar:

```javascript
// Ver conexión Echo
console.log(Echo);

// Ver canales suscritos
Echo.connector.pusher.channels.channels;
```

### Herramientas de Debug

-   **Pusher Debug Console**: En pusher.com → Dashboard → Debug Console
-   **Reverb Dashboard**: `php artisan reverb:start --debug`
-   **Soketi Debug**: Iniciar con `--debug` flag

## Troubleshooting

### Eventos no llegan al frontend

1. Verificar que el servidor WebSocket esté corriendo (Reverb/Soketi)
2. Verificar credenciales en `.env` y `.env` de Vite
3. Compilar assets: `npm run build`
4. Verificar autenticación de canales privados
5. Revisar logs del navegador (F12 → Console)
6. Verificar que la cola esté corriendo: `php artisan queue:work`

### Error 403 Forbidden en canales privados

-   Verificar que el usuario esté autenticado
-   Verificar autorización en `routes/channels.php`
-   Verificar token CSRF en headers de Echo

### WebSocket no conecta

-   Verificar firewall/puertos abiertos
-   Verificar esquema (http vs https, ws vs wss)
-   Usar `forceTLS: false` en desarrollo local

## Recursos

-   [Laravel Broadcasting Docs](https://laravel.com/docs/broadcasting)
-   [Laravel Echo Docs](https://laravel.com/docs/broadcasting#client-side-installation)
-   [Pusher Documentation](https://pusher.com/docs)
-   [Laravel Reverb](https://laravel.com/docs/reverb)
-   [Soketi Documentation](https://docs.soketi.app/)
