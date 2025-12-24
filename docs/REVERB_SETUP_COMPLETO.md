# Configuración Completa: Laravel Reverb (Broadcasting)

## 📦 ¿Qué es Laravel Reverb?

Laravel Reverb es un servidor WebSocket de primera parte incluido en Laravel 11+ que proporciona broadcasting en tiempo real sin necesidad de servicios externos como Pusher.

### Ventajas

-   ✅ Gratuito y open source
-   ✅ Configuración sencilla
-   ✅ Compatible con Laravel Echo
-   ✅ Sin límites de conexiones o mensajes
-   ✅ Ideal para desarrollo y producción

---

## 🚀 Parte 1: Instalación Backend

### 1. Instalar Reverb

```bash
php artisan install:broadcasting
```

Este comando:

-   Instala el paquete `laravel/reverb`
-   Crea `config/reverb.php`
-   Configura `config/broadcasting.php`
-   Actualiza `.env` con configuración por defecto

### 2. Verificar `.env`

```env
BROADCAST_DRIVER=reverb

REVERB_APP_ID=talentus
REVERB_APP_KEY=local-key
REVERB_APP_SECRET=local-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

### 3. Configurar Canales de Broadcasting

El archivo `routes/channels.php` ya debe tener:

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

### 4. Iniciar Servidor Reverb

```bash
php artisan reverb:start
```

Deberías ver:

```
┌───────────────────────────────────────────────────────────────┐
│                        Laravel Reverb                          │
└───────────────────────────────────────────────────────────────┘

  Reverb server started on http://localhost:8080
```

**Opciones útiles:**

```bash
# Con debug
php artisan reverb:start --debug

# En un puerto diferente
php artisan reverb:start --port=6001

# Con host específico
php artisan reverb:start --host=0.0.0.0
```

### 5. Eventos Broadcasting Ya Creados

Los eventos ya están listos:

-   `App\Events\WorkOrderCreated` - Disparado al crear una orden
-   `App\Events\WorkOrderUpdated` - Disparado al actualizar una orden

Se disparan automáticamente desde `WorkOrderObserver`.

---

## 💻 Parte 2: Configuración Frontend (Blade + Livewire)

### 1. Instalar Paquetes NPM

```bash
npm install --save-dev laravel-echo pusher-js
```

### 2. Configurar Echo en `resources/js/app.js`

Agregar al final del archivo:

```javascript
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
    auth: {
        headers: {
            "X-CSRF-TOKEN":
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content") || "",
        },
    },
});

// Log de conexión (opcional, para debug)
window.Echo.connector.pusher.connection.bind("connected", () => {
    console.log("✅ Reverb conectado");
});

window.Echo.connector.pusher.connection.bind("error", (err) => {
    console.error("❌ Error Reverb:", err);
});
```

### 3. Verificar Meta Tag CSRF

En `resources/views/layouts/app.blade.php` (o el layout que uses):

```blade
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

### 4. Compilar Assets

```bash
npm run build

# O para desarrollo con hot reload
npm run dev
```

---

## 🔔 Parte 3: Escuchar Eventos en el Frontend

### Opción A: JavaScript Directo (Recomendado para notificaciones)

Agregar en cualquier vista Blade (ej: `resources/views/admin/layouts/app.blade.php`):

```blade
@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Escuchar en canal privado del usuario autenticado
    window.Echo.private('user.{{ auth()->id() }}')
        .listen('.work-order.created', (event) => {
            console.log('Nueva orden creada:', event);

            // Mostrar notificación con WireUI
            if (window.$wireui) {
                window.$wireui.notify({
                    title: '🔧 Nueva Orden Asignada',
                    description: `Orden ${event.codigo} - ${event.tipo}`,
                    icon: 'success',
                    timeout: 10000,
                });
            }

            // Actualizar componente Livewire si existe
            if (window.Livewire) {
                window.Livewire.dispatch('work-order-created', event);
            }
        })
        .listen('.work-order.updated', (event) => {
            console.log('Orden actualizada:', event);

            if (window.$wireui) {
                window.$wireui.notify({
                    title: 'Orden Actualizada',
                    description: `${event.codigo} - Estado: ${event.estado}`,
                    icon: 'info',
                });
            }

            if (window.Livewire) {
                window.Livewire.dispatch('work-order-updated', event);
            }
        });

    // Escuchar en canal de empresa
    window.Echo.private('empresa.{{ session("empresa") }}')
        .listen('.work-order.created', (event) => {
            console.log('Nueva orden en empresa:', event);
        });
});
</script>
@endauth
```

### Opción B: Desde Componente Livewire

En `app/Livewire/Admin/WorkOrders/Index.php`:

```php
use Livewire\Attributes\On;

#[On('work-order-created')]
public function handleWorkOrderCreated($event)
{
    // Refrescar la tabla
    $this->dispatch('$refresh');
}

#[On('work-order-updated')]
public function handleWorkOrderUpdated($event)
{
    // Refrescar la tabla
    $this->dispatch('$refresh');
}
```

---

## 🧪 Testing

### 1. Verificar Conexión

Abrir consola del navegador (F12) y ejecutar:

```javascript
// Ver estado de Echo
console.log(window.Echo);

// Ver canales suscritos
console.log(window.Echo.connector.pusher.channels.channels);

// Ver estado de conexión
console.log(window.Echo.connector.pusher.connection.state);
```

### 2. Probar Eventos desde Tinker

```bash
php artisan tinker
```

```php
$workOrder = WorkOrder::first();

// Disparar evento manualmente
event(new \App\Events\WorkOrderCreated($workOrder));

// Esperar 2 segundos y verificar en el navegador
```

### 3. Probar con Reverb Debug

Terminal 1:

```bash
php artisan reverb:start --debug
```

Terminal 2:

```bash
php artisan tinker
>>> event(new \App\Events\WorkOrderCreated(WorkOrder::first()));
```

Deberías ver en Terminal 1 el mensaje siendo transmitido.

---

## 📱 Parte 4: Escuchar en App Móvil (Flutter)

### 1. Instalar Paquete

```yaml
dependencies:
    laravel_echo: ^2.0.0
    pusher_client_fixed: ^1.1.1
    socket_io_client: ^2.0.3
```

### 2. Configurar Echo en Flutter

```dart
import 'package:laravel_echo/laravel_echo.dart';
import 'package:pusher_client_fixed/pusher_client_fixed.dart';

class EchoService {
  static Echo? _echo;

  static Future<void> init(String authToken, int userId) async {
    PusherOptions options = PusherOptions(
      host: 'tudominio.com', // o IP del servidor
      wsPort: 8080,
      wssPort: 8080,
      encrypted: true, // true si usas HTTPS
      auth: PusherAuth(
        'https://tudominio.com/broadcasting/auth',
        headers: {
          'Authorization': 'Bearer $authToken',
          'Accept': 'application/json',
        },
      ),
    );

    _echo = Echo(
      broadcaster: EchoBroadcasterType.Pusher,
      client: PusherClient(
        'local-key', // Tu REVERB_APP_KEY
        options,
        autoConnect: true,
      ),
    );

    // Escuchar canal privado
    _echo!
        .private('user.$userId')
        .listen('.work-order.created', (event) {
      print('Nueva orden: $event');
      // Mostrar notificación local
      // Navegar si es necesario
    })
        .listen('.work-order.updated', (event) {
      print('Orden actualizada: $event');
    });
  }

  static void disconnect() {
    _echo?.disconnect();
  }
}
```

### 3. Inicializar en `main.dart`

```dart
void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Después de login exitoso
  await EchoService.init(authToken, userId);

  runApp(MyApp());
}
```

---

## 🐳 Producción con Supervisor (Linux)

### 1. Crear Configuración Supervisor

Crear `/etc/supervisor/conf.d/reverb.conf`:

```ini
[program:reverb]
process_name=%(program_name)s
command=php /var/www/talentus/artisan reverb:start --host=0.0.0.0 --port=8080
autostart=true
autorestart=true
stopaspropagate=true
stopwaitsecs=3600
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/talentus/storage/logs/reverb.log
```

### 2. Actualizar Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start reverb
```

### 3. Configurar Nginx (Proxy WebSocket)

Agregar en tu configuración Nginx:

```nginx
server {
    listen 443 ssl http2;
    server_name tudominio.com;

    # ... otras configuraciones

    # Proxy para Reverb WebSocket
    location /reverb {
        proxy_pass http://127.0.0.1:8080;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_read_timeout 86400;
    }
}
```

### 4. Actualizar `.env` en Producción

```env
BROADCAST_DRIVER=reverb

REVERB_APP_ID=production
REVERB_APP_KEY=tu-key-segura-aqui
REVERB_APP_SECRET=tu-secret-seguro-aqui
REVERB_HOST=tudominio.com
REVERB_PORT=443
REVERB_SCHEME=https

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

---

## 🔍 Troubleshooting

### Eventos no llegan al frontend

1. **Verificar servidor Reverb corriendo**:

    ```bash
    ps aux | grep reverb
    ```

2. **Verificar assets compilados**:

    ```bash
    npm run build
    ```

3. **Verificar conexión WebSocket en navegador**:

    - Abrir DevTools → Network → WS
    - Debería ver conexión a `ws://localhost:8080`

4. **Verificar autenticación de canales**:
    - En Network → Headers de la petición `/broadcasting/auth`
    - Debe tener token CSRF correcto

### Error 403 en canales privados

-   Verificar que el usuario esté autenticado
-   Verificar lógica de autorización en `routes/channels.php`
-   Verificar token CSRF en headers

### Reverb se desconecta constantemente

-   Aumentar `max_execution_time` en `php.ini`
-   Usar Supervisor en producción
-   Verificar logs: `tail -f storage/logs/reverb.log`

### No aparece meta tag CSRF

Agregar en el layout:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## 📊 Monitoreo

### Dashboard de Reverb

Reverb incluye un dashboard básico. Acceder en:

```
http://localhost:8080/_reverb/dashboard
```

### Logs

```bash
tail -f storage/logs/reverb.log
```

### Métricas

Ver conexiones activas:

```bash
php artisan reverb:restart
```

---

## 🆚 Reverb vs Pusher vs Soketi

| Característica | Reverb | Pusher     | Soketi   |
| -------------- | ------ | ---------- | -------- |
| Costo          | Gratis | Freemium   | Gratis   |
| Setup          | Simple | Muy simple | Medio    |
| Producción     | ✅ Sí  | ✅ Sí      | ✅ Sí    |
| Self-hosted    | ✅ Sí  | ❌ No      | ✅ Sí    |
| Dashboard      | Básico | Completo   | Completo |
| Escalabilidad  | Media  | Alta       | Alta     |

**Recomendación**: Usar Reverb para proyectos pequeños/medianos y desarrollo. Para alta escala considerar Pusher o cluster de Soketi.

---

## 📚 Recursos

-   [Laravel Reverb Documentation](https://laravel.com/docs/reverb)
-   [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
-   [Laravel Echo](https://laravel.com/docs/broadcasting#client-side-installation)
