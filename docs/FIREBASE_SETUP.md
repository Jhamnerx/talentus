# Configuración de Notificaciones Push Firebase

## Instalación del Paquete

```bash
composer require notificationchannels/fcm
```

## Configuración

### 1. Agregar en `config/services.php`

```php
'fcm' => [
    'key' => env('FCM_SERVER_KEY'),
    'project_id' => env('FCM_PROJECT_ID'),
],
```

### 2. Variables de Entorno (.env)

```env
FCM_SERVER_KEY=your_firebase_server_key_here
FCM_PROJECT_ID=your_firebase_project_id_here
```

### 3. Obtener las Credenciales de Firebase

1. Ve a [Firebase Console](https://console.firebase.google.com/)
2. Selecciona tu proyecto o crea uno nuevo
3. Ve a **Project Settings** (⚙️) → **Cloud Messaging**
4. Copia el **Server Key** (Legacy) y agrega a `FCM_SERVER_KEY`
5. El **Project ID** está en la parte superior de Project Settings

### 4. Configurar en la App Móvil

#### Android (Flutter ejemplo)

```dart
// pubspec.yaml
dependencies:
  firebase_messaging: ^14.0.0
  flutter_local_notifications: ^16.0.0

// main.dart
import 'package:firebase_messaging/firebase_messaging.dart';

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  print('Handling background message: ${message.messageId}');
}

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();

  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  // Solicitar permisos
  NotificationSettings settings = await FirebaseMessaging.instance.requestPermission(
    alert: true,
    badge: true,
    sound: true,
  );

  // Obtener el token del dispositivo
  String? token = await FirebaseMessaging.instance.getToken();
  print('FCM Token: $token');

  // Enviar token al backend
  // api.sendFcmToken(token);

  runApp(MyApp());
}

// Escuchar mensajes en foreground
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  print('Got a message in foreground!');
  print('Message data: ${message.data}');

  if (message.notification != null) {
    print('Message also contained a notification: ${message.notification}');
    // Mostrar notificación local
  }
});

// Manejar tap en notificación
FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
  print('A new onMessageOpenedApp event was published!');

  // Navegar a la pantalla correspondiente
  if (message.data['work_order_id'] != null) {
    Navigator.pushNamed(context, '/work-order-detail',
      arguments: {'id': message.data['work_order_id']}
    );
  }
});
```

### 5. Guardar el Token FCM del Usuario

En el backend, necesitas una columna para guardar el token:

```bash
php artisan make:migration add_fcm_token_to_users_table
```

```php
// Migration
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('fcm_token')->nullable()->after('remember_token');
    });
}

// Model User.php
protected $fillable = [
    // ... otros campos
    'fcm_token',
];

// API Controller para recibir el token
public function saveFcmToken(Request $request)
{
    $request->validate([
        'token' => 'required|string',
    ]);

    auth()->user()->update([
        'fcm_token' => $request->token,
    ]);

    return response()->json(['message' => 'Token saved successfully']);
}
```

### 6. Enviar Notificación desde el Backend

#### Opción A: Usando las Notificaciones creadas

```php
use App\Notifications\NuevaOrdenAsignada;

// En cualquier parte del código (Controller, Observer, Job)
$tecnico = User::find($tecnico_id);
$tecnico->notify(new NuevaOrdenAsignada($workOrder));
```

#### Opción B: Enviar manualmente

```php
use Illuminate\Support\Facades\Http;

$serverKey = config('services.fcm.key');
$url = 'https://fcm.googleapis.com/fcm/send';

$notification = [
    'title' => 'Nueva Orden de Trabajo',
    'body' => 'Orden OT25-000123 asignada',
    'sound' => 'default',
    'badge' => '1',
];

$data = [
    'work_order_id' => $workOrder->id,
    'action' => 'work_order_assigned',
];

$fields = [
    'to' => $userFcmToken, // Token del usuario
    'notification' => $notification,
    'data' => $data,
    'priority' => 'high',
];

$response = Http::withHeaders([
    'Authorization' => 'key=' . $serverKey,
    'Content-Type' => 'application/json',
])->post($url, $fields);
```

## Testing

### Probar Notificación desde Postman

```http
POST https://fcm.googleapis.com/fcm/send
Headers:
  Authorization: key=YOUR_SERVER_KEY
  Content-Type: application/json

Body:
{
  "to": "USER_FCM_TOKEN_HERE",
  "notification": {
    "title": "Test Notification",
    "body": "This is a test",
    "sound": "default"
  },
  "data": {
    "key": "value"
  }
}
```

### Probar desde Artisan Tinker

```php
php artisan tinker

$user = User::find(1);
$workOrder = WorkOrder::first();
$user->notify(new \App\Notifications\NuevaOrdenAsignada($workOrder));
```

## Canales de Notificación Android

Para mejor organización de notificaciones en Android:

```kotlin
// Android Native
if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
    val channelId = "work_orders"
    val channelName = "Órdenes de Trabajo"
    val importance = NotificationManager.IMPORTANCE_HIGH

    val channel = NotificationChannel(channelId, channelName, importance).apply {
        description = "Notificaciones de órdenes de trabajo asignadas"
        enableLights(true)
        lightColor = Color.BLUE
        enableVibration(true)
    }

    val notificationManager = getSystemService(NotificationManager::class.java)
    notificationManager.createNotificationChannel(channel)
}
```

## Troubleshooting

### Notificaciones no llegan

1. Verificar que FCM_SERVER_KEY esté correcto
2. Verificar que el token del usuario esté actualizado
3. Revisar logs de Laravel: `tail -f storage/logs/laravel.log`
4. Verificar que la cola esté corriendo: `php artisan queue:work`
5. Verificar conexión a internet en el dispositivo móvil

### Token inválido

Si recibes error "InvalidRegistration":

-   El token FCM expiró o es inválido
-   Solicitar nuevo token desde la app móvil
-   Actualizar en la base de datos

### Notificaciones duplicadas

-   Asegurarse de que `ShouldQueue` esté implementado en la notificación
-   Verificar que no haya múltiples listeners del mismo evento

## Recursos

-   [Firebase Cloud Messaging Docs](https://firebase.google.com/docs/cloud-messaging)
-   [Laravel FCM Channel](https://github.com/laravel-notification-channels/fcm)
-   [Flutter Firebase Messaging](https://pub.dev/packages/firebase_messaging)
