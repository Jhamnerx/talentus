# Configuración Completa: Firebase + Laravel Reverb

## 📦 Paquetes Instalados

```bash
composer require laravel-notification-channels/fcm
```

Este paquete incluye:

-   `kreait/laravel-firebase` - Cliente Firebase para Laravel
-   `kreait/firebase-php` - SDK Firebase PHP
-   Integración automática con Laravel Notifications

---

## 🔧 Parte 1: Configuración Firebase (Backend)

### 1. Obtener Credenciales de Firebase

1. Ve a [Firebase Console](https://console.firebase.google.com/)
2. Crea un proyecto o selecciona uno existente
3. Ve a **Project Settings** (⚙️ arriba a la izquierda)
4. Pestaña **Service accounts**
5. Click en **Generate new private key**
6. Descarga el archivo JSON

### 2. Configurar Archivo de Credenciales

Guarda el archivo JSON descargado en:

```
storage/app/firebase/firebase-credentials.json
```

⚠️ **IMPORTANTE**: Agregar a `.gitignore`:

```gitignore
storage/app/firebase/
```

### 3. Configurar Laravel (`config/services.php`)

Agregar al final del archivo:

```php
'firebase' => [
    'credentials' => [
        'file' => storage_path('app/firebase/firebase-credentials.json'),
    ],
],
```

### 4. Publicar Configuración (Opcional pero recomendado)

```bash
php artisan vendor:publish --provider="Kreait\Laravel\Firebase\ServiceProvider" --tag="config"
```

Esto crea `config/firebase.php` donde puedes personalizar más opciones.

---

## 📱 Parte 2: Migración y Modelo User

### 1. Ejecutar Migración

```bash
php artisan migrate
```

Esto agregará el campo `fcm_token` a la tabla `users`.

### 2. Verificar Modelo User

El modelo `app/Models/User.php` ya tiene:

```php
protected $fillable = [
    // ... otros campos
    'fcm_token',
];

public function routeNotificationForFcm()
{
    return $this->fcm_token;
}
```

---

## 🔔 Parte 3: Notificaciones

Las notificaciones ya están creadas y listas:

### Notificaciones Disponibles

1. **`NuevaOrdenAsignada`** - Se envía cuando se asigna una orden al técnico
2. **`OrdenCambioEstado`** - Se envía cuando cambia el estado de una orden

### Uso Automático

Las notificaciones se disparan automáticamente desde el `WorkOrderObserver`:

```php
// Al crear una orden
$workOrder->tecnico->notify(new NuevaOrdenAsignada($workOrder));

// Al cambiar estado
$workOrder->tecnico->notify(new OrdenCambioEstado($workOrder, $estadoAnterior));
```

### Estructura del Payload

```json
{
    "notification": {
        "title": "🔧 Nueva Orden de Trabajo Asignada",
        "body": "Orden OT25-000123 - Instalación GPS | Vehículo: ABC-123"
    },
    "data": {
        "work_order_id": "123",
        "work_order_codigo": "OT25-000123",
        "tipo": "Instalación GPS",
        "vehiculo_placa": "ABC-123",
        "vehiculo_id": "456",
        "cliente_nombre": "Empresa XYZ",
        "fecha_programada": "2025-12-24 14:30",
        "action": "work_order_assigned",
        "url": "https://app.com/admin/work-orders/123"
    },
    "android": {
        "priority": "high",
        "notification": {
            "sound": "default",
            "channel_id": "work_orders",
            "click_action": "FLUTTER_NOTIFICATION_CLICK"
        }
    },
    "apns": {
        "payload": {
            "aps": {
                "sound": "default",
                "badge": 1
            }
        }
    }
}
```

---

## 📲 Parte 4: Configuración App Móvil (Flutter)

### 1. Agregar Dependencias (`pubspec.yaml`)

```yaml
dependencies:
    flutter:
        sdk: flutter
    firebase_core: ^3.3.0
    firebase_messaging: ^15.0.4
    flutter_local_notifications: ^18.0.1
    http: ^1.2.0
```

### 2. Configurar Firebase en la App

#### Android (`android/app/build.gradle`)

```gradle
dependencies {
    implementation platform('com.google.firebase:firebase-bom:33.1.2')
    implementation 'com.google.firebase:firebase-messaging'
}
```

En `android/build.gradle`:

```gradle
dependencies {
    classpath 'com.google.gms:google-services:4.4.2'
}
```

En `android/app/build.gradle` al final:

```gradle
apply plugin: 'com.google.gms.google-services'
```

Descargar `google-services.json` desde Firebase Console y colocar en:

```
android/app/google-services.json
```

#### iOS (`ios/Runner/Info.plist`)

Descargar `GoogleService-Info.plist` desde Firebase Console y agregarlo al proyecto iOS.

### 3. Código Flutter Principal (`lib/main.dart`)

```dart
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

// Manejo de notificaciones en background
@pragma('vm:entry-point')
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  await Firebase.initializeApp();
  print('Mensaje en background: ${message.messageId}');
}

// Configuración de canal de notificaciones Android
final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
    FlutterLocalNotificationsPlugin();

const AndroidNotificationChannel channel = AndroidNotificationChannel(
  'work_orders',
  'Órdenes de Trabajo',
  description: 'Notificaciones de órdenes de trabajo asignadas',
  importance: Importance.high,
);

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Inicializar Firebase
  await Firebase.initializeApp();

  // Configurar handler de background
  FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

  // Crear canal de notificaciones en Android
  await flutterLocalNotificationsPlugin
      .resolvePlatformSpecificImplementation<
          AndroidFlutterLocalNotificationsPlugin>()
      ?.createNotificationChannel(channel);

  // Configurar notificaciones locales
  const AndroidInitializationSettings initializationSettingsAndroid =
      AndroidInitializationSettings('@mipmap/ic_launcher');

  const InitializationSettings initializationSettings = InitializationSettings(
    android: initializationSettingsAndroid,
  );

  await flutterLocalNotificationsPlugin.initialize(
    initializationSettings,
    onDidReceiveNotificationResponse: (NotificationResponse response) {
      // Manejar tap en notificación
      if (response.payload != null) {
        final data = jsonDecode(response.payload!);
        // Navegar a la pantalla correspondiente
        navigateToWorkOrder(data['work_order_id']);
      }
    },
  );

  runApp(MyApp());
}

class MyApp extends StatefulWidget {
  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {

  @override
  void initState() {
    super.initState();
    _setupFirebaseMessaging();
  }

  Future<void> _setupFirebaseMessaging() async {
    // Solicitar permisos (iOS)
    NotificationSettings settings = await FirebaseMessaging.instance.requestPermission(
      alert: true,
      badge: true,
      sound: true,
      provisional: false,
    );

    if (settings.authorizationStatus == AuthorizationStatus.authorized) {
      print('Permisos de notificación otorgados');

      // Obtener token FCM
      String? token = await FirebaseMessaging.instance.getToken();
      if (token != null) {
        print('Token FCM: $token');
        await _sendTokenToBackend(token);
      }

      // Escuchar cuando se actualiza el token
      FirebaseMessaging.instance.onTokenRefresh.listen(_sendTokenToBackend);

      // Escuchar mensajes cuando la app está en foreground
      FirebaseMessaging.onMessage.listen((RemoteMessage message) {
        print('Mensaje recibido en foreground: ${message.notification?.title}');

        // Mostrar notificación local
        if (message.notification != null) {
          _showLocalNotification(message);
        }
      });

      // Manejar tap en notificación cuando app está cerrada o en background
      FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
        print('Notificación tocada: ${message.data}');

        if (message.data['work_order_id'] != null) {
          navigateToWorkOrder(message.data['work_order_id']);
        }
      });

      // Verificar si la app se abrió desde una notificación
      RemoteMessage? initialMessage = await FirebaseMessaging.instance.getInitialMessage();
      if (initialMessage != null) {
        navigateToWorkOrder(initialMessage.data['work_order_id']);
      }
    }
  }

  Future<void> _sendTokenToBackend(String token) async {
    try {
      final response = await http.post(
        Uri.parse('https://tudominio.com/api/fcm/token'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ${getAuthToken()}', // Tu token de autenticación
          'Accept': 'application/json',
        },
        body: jsonEncode({'token': token}),
      );

      if (response.statusCode == 200) {
        print('Token FCM enviado al backend exitosamente');
      }
    } catch (e) {
      print('Error enviando token al backend: $e');
    }
  }

  Future<void> _showLocalNotification(RemoteMessage message) async {
    RemoteNotification? notification = message.notification;
    AndroidNotification? android = message.notification?.android;

    if (notification != null && android != null) {
      flutterLocalNotificationsPlugin.show(
        notification.hashCode,
        notification.title,
        notification.body,
        NotificationDetails(
          android: AndroidNotificationDetails(
            channel.id,
            channel.name,
            channelDescription: channel.description,
            icon: '@mipmap/ic_launcher',
            importance: Importance.high,
            priority: Priority.high,
          ),
        ),
        payload: jsonEncode(message.data),
      );
    }
  }

  void navigateToWorkOrder(String workOrderId) {
    // Implementar navegación a la pantalla de detalle
    Navigator.pushNamed(context, '/work-order-detail', arguments: workOrderId);
  }

  String getAuthToken() {
    // Obtener token de autenticación guardado
    return 'tu_token_sanctum_aqui';
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Talentus GPS',
      home: HomeScreen(),
    );
  }
}
```

### 4. Eliminar Token al Cerrar Sesión

```dart
Future<void> logout() async {
  try {
    await http.delete(
      Uri.parse('https://tudominio.com/api/fcm/token'),
      headers: {
        'Authorization': 'Bearer ${getAuthToken()}',
        'Accept': 'application/json',
      },
    );

    // Limpiar sesión local
    // ...
  } catch (e) {
    print('Error eliminando token: $e');
  }
}
```

---

## 🧪 Testing de Notificaciones

### Desde Tinker

```bash
php artisan tinker
```

```php
$user = User::find(1);
$user->fcm_token = 'token_de_prueba_aqui';
$user->save();

$workOrder = WorkOrder::first();
$user->notify(new \App\Notifications\NuevaOrdenAsignada($workOrder));
```

### Desde Postman (Simular App Móvil)

**Guardar Token FCM:**

```http
POST https://tudominio.com/api/fcm/token
Headers:
  Authorization: Bearer {sanctum_token}
  Accept: application/json
  Content-Type: application/json

Body:
{
  "token": "token_fcm_de_la_app_movil"
}
```

**Eliminar Token FCM:**

```http
DELETE https://tudominio.com/api/fcm/token
Headers:
  Authorization: Bearer {sanctum_token}
  Accept: application/json
```

---

## 🔍 Troubleshooting

### Notificaciones no llegan

1. **Verificar que las colas estén corriendo**:

    ```bash
    php artisan queue:work
    ```

2. **Verificar credenciales Firebase**:

    - Archivo JSON en `storage/app/firebase/`
    - Permisos de lectura del archivo

3. **Verificar token FCM del usuario**:

    ```sql
    SELECT id, name, fcm_token FROM users WHERE fcm_token IS NOT NULL;
    ```

4. **Revisar logs**:
    ```bash
    tail -f storage/logs/laravel.log
    ```

### Token expirado o inválido

El listener `DeleteExpiredFcmTokens` automáticamente limpiará tokens expirados y registrará en el log.

### Permisos Android

En `AndroidManifest.xml`:

```xml
<uses-permission android:name="android.permission.INTERNET"/>
<uses-permission android:name="android.permission.POST_NOTIFICATIONS"/>
```

---

## 📚 Recursos

-   [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging)
-   [laravel-notification-channels/fcm](https://github.com/laravel-notification-channels/fcm)
-   [Firebase Messaging Flutter](https://firebase.flutter.dev/docs/messaging/overview/)
