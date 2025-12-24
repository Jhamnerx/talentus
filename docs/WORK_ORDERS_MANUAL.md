# Manual Completo - Sistema de Órdenes de Trabajo (Work Orders)

## 📋 Índice

1. [Introducción](#introducción)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Flujo de Trabajo Completo](#flujo-de-trabajo-completo)
4. [Modelos y Relaciones](#modelos-y-relaciones)
5. [Estados de las Órdenes](#estados-de-las-órdenes)
6. [Sistema de Checklist](#sistema-de-checklist)
7. [Gestión de Dispositivos](#gestión-de-dispositivos)
8. [Evidencias Fotográficas](#evidencias-fotográficas)
9. [Firmas Digitales](#firmas-digitales)
10. [Notificaciones y Eventos](#notificaciones-y-eventos)
11. [Roles y Permisos](#roles-y-permisos)
12. [API Endpoints](#api-endpoints)

---

## 🎯 Introducción

El sistema de **Work Orders** (Órdenes de Trabajo) reemplaza completamente el módulo anterior de **Tareas**, proporcionando un sistema robusto, auditable y defendible ante reclamos para la gestión de:

-   Instalaciones de dispositivos GPS
-   Retiro de dispositivos
-   Mantenimientos preventivos y correctivos
-   Certificaciones vehiculares
-   Cualquier tipo de servicio técnico configurable

### Diferencias Clave vs Sistema Anterior (Tareas)

| Característica         | Tareas (Anterior)  | Work Orders (Nuevo)          |
| ---------------------- | ------------------ | ---------------------------- |
| Checklist              | No tiene           | ✅ Dinámico BEFORE/AFTER     |
| Firmas Digitales       | No tiene           | ✅ Con hash SHA256           |
| Evidencias             | Campo texto simple | ✅ Tabla completa con GPS    |
| Historial Dispositivos | Sobrescribe datos  | ✅ Inmutable, append-only    |
| Bloqueo post-cierre    | Soft delete        | ✅ Campo `bloqueado`         |
| Auditabilidad          | Limitada           | ✅ Completa con Activity Log |

---

## 🏗️ Arquitectura del Sistema

### Tablas Principales

```
work_order_types          → Tipos de órdenes configurables
work_orders               → Órdenes principales
device_history            → Historial de dispositivos (INMUTABLE)
checklist_templates       → Plantillas de ítems a inspeccionar
work_order_checklists     → Ejecución de checklist (before/after)
work_order_photos         → Evidencias fotográficas con GPS
work_order_signatures     → Firmas digitales con metadata
work_order_accessories    → Accesorios instalados/retirados
```

### Enums Principales

```php
// WorkOrderStatus
PENDIENTE     → Orden creada, esperando inicio
EN_PROCESO    → Técnico trabajando
FINALIZADO    → Trabajo completado, esperando cierre
CANCELADO     → Orden cancelada con motivo

// ChecklistResultado
OK            → Ítem en buen estado
OBSERVADO     → Ítem con observaciones
NO_APLICA     → Ítem no corresponde a este vehículo

// ChecklistCategoria
VEHICULO      → Carrocería, pintura
TABLERO       → Instrumentos, testigos
LUCES         → Delanteras, posteriores
ACCESORIOS    → Llanta, gata, etc.
MOTOR         → Mecánica
NEUMATICOS    → Estado de llantas
DOCUMENTOS    → SOAT, tarjeta propiedad
OTROS         → Personalizables
```

---

## 🔄 Flujo de Trabajo Completo

### Fase 1: Creación de Orden (ADMIN)

**Actor:** Administrador o Supervisor

1. **Seleccionar Tipo de Orden**

    - Instalación GPS
    - Retiro GPS
    - Mantenimiento Preventivo
    - Certificación
    - Otros (configurables)

2. **Asignar Recursos**

    - Vehículo (con autocarga de cliente)
    - Cliente (auto-detectado)
    - Técnico responsable
    - Fecha programada

3. **Observaciones Iniciales**

    - Requerimientos especiales
    - Instrucciones para el técnico
    - Notas internas

4. **Sistema Automático**
    ```php
    // Al crear la orden:
    - Genera código único: OT25-000001
    - Crea UUID para tracking
    - Registra empresa_id y created_by
    - Estado inicial: PENDIENTE
    - Dispara notificación al técnico
    - Emite evento de socket para app móvil
    ```

### Fase 2: Inicio de Trabajo (TÉCNICO)

**Actor:** Técnico Asignado

1. **Recibe Notificación**

    - Push notification en app móvil
    - Email con detalles
    - Evento en tiempo real vía socket

2. **Acepta y Comienza**

    ```php
    $workOrder->iniciar();
    // Cambia estado a EN_PROCESO
    // Registra fecha_inicio
    // Notifica al admin del inicio
    ```

3. **Accede a Información**
    - Datos del vehículo
    - Ubicación del cliente
    - Instrucciones especiales
    - Historial de dispositivos previos

### Fase 3: Checklist BEFORE (TÉCNICO)

**Actor:** Técnico en Campo

#### 3.1 Inspección Exterior del Vehículo

```
CARROCERÍA Y PINTURA
✓ Pintura - Estado General          [OK/OBSERVADO/NO_APLICA]
  └─ Observaciones: _______________
  └─ Foto requerida: SÍ

✓ Emblemas/Logos                    [OK/OBSERVADO/NO_APLICA]
✓ Espejos (izq/der)                 [OK/OBSERVADO/NO_APLICA]
✓ Antena                            [OK/OBSERVADO/NO_APLICA]
```

#### 3.2 Luces

```
LUCES DELANTERAS
✓ Faros principales                 [OK/OBSERVADO/NO_APLICA]
✓ Direccionales                     [OK/OBSERVADO/NO_APLICA]
✓ Neblineros                        [OK/OBSERVADO/NO_APLICA]

LUCES POSTERIORES
✓ Stop                              [OK/OBSERVADO/NO_APLICA]
✓ Direccionales                     [OK/OBSERVADO/NO_APLICA]
✓ Retroceso                         [OK/OBSERVADO/NO_APLICA]
✓ Placa                             [OK/OBSERVADO/NO_APLICA]
```

#### 3.3 Tablero e Instrumentos

```
TABLERO DE INSTRUMENTOS
✓ Velocímetro                       [OK/OBSERVADO/NO_APLICA]
✓ Tacómetro                         [OK/OBSERVADO/NO_APLICA]
✓ Indicador combustible             [OK/OBSERVADO/NO_APLICA]
✓ Testigos luminosos                [OK/OBSERVADO/NO_APLICA]
✓ Alarmas                           [OK/OBSERVADO/NO_APLICA]
✓ Claxon eléctrico                  [OK/OBSERVADO/NO_APLICA]
```

#### 3.4 Interior

```
INTERIOR DEL VEHÍCULO
✓ Tapiz asientos                    [OK/OBSERVADO/NO_APLICA]
✓ Limpieza general                  [OK/OBSERVADO/NO_APLICA]
✓ Gavetas/compartimientos           [OK/OBSERVADO/NO_APLICA]
✓ Brazos limpiadores                [OK/OBSERVADO/NO_APLICA]
✓ Plumillas                         [OK/OBSERVADO/NO_APLICA]
✓ Pestillos mecánicos               [OK/OBSERVADO/NO_APLICA]
✓ Pestillos eléctricos              [OK/OBSERVADO/NO_APLICA]
✓ Máscara radio                     [OK/OBSERVADO/NO_APLICA]
```

#### 3.5 Accesorios

```
ACCESORIOS DEL VEHÍCULO
✓ Llanta de repuesto                [OK/OBSERVADO/NO_APLICA]
✓ Gata                              [OK/OBSERVADO/NO_APLICA]
✓ Llave de ruedas                   [OK/OBSERVADO/NO_APLICA]
✓ Tapa tanque combustible           [OK/OBSERVADO/NO_APLICA]
✓ Pisos: Jebes                      [OK/OBSERVADO/NO_APLICA]
✓ Pisos: Alfombras                  [OK/OBSERVADO/NO_APLICA]
```

#### 3.6 Documentos

```
DOCUMENTACIÓN
✓ Tarjeta de propiedad              [OK/OBSERVADO/NO_APLICA]
✓ SOAT vigente                      [OK/OBSERVADO/NO_APLICA]
✓ Revisión técnica vigente          [OK/OBSERVADO/NO_APLICA]
```

#### 3.7 Observaciones Generales BEFORE

```
OBSERVACIONES DEL TÉCNICO (ANTES):
_________________________________________
_________________________________________
_________________________________________

OBSERVACIONES DEL CLIENTE (ANTES):
_________________________________________
_________________________________________
_________________________________________

FIRMA RECEPCIÓN CLIENTE: ____________
Fecha/Hora: _______  GPS: Lat/Lng
```

### Fase 4: Ejecución del Trabajo (TÉCNICO)

#### 4.1 Registro de Dispositivos (Si aplica)

**Para Instalaciones:**

```
DISPOSITIVO GPS
├─ IMEI: _______________  (15 dígitos)
├─ Modelo: _____________  (Select de catálogo)
├─ Número serie: _______
├─ Ubicación instalación: ___________
└─ Foto instalación: [REQUERIDA]

SIM CARD
├─ ICCID: ______________  (19-20 dígitos)
├─ Número línea: _______
├─ Operador: ___________
├─ Plan: _______________
└─ Foto SIM: [REQUERIDA]

ACCESORIOS INSTALADOS
├─ Micrófono: SÍ/NO
├─ Botón pánico: SÍ/NO
├─ Relé corta corriente: SÍ/NO
├─ Sensor puerta: SÍ/NO
└─ Otros: ______________
```

**Para Retiros:**

```
DISPOSITIVO RETIRADO
├─ IMEI retirado: ______
├─ Estado: [FUNCIONAL/DAÑADO/PERDIDO]
├─ Motivo retiro: ______
└─ Foto antes retiro: [REQUERIDA]

SIM RETIRADA
├─ ICCID: _____________
├─ Estado: ____________
└─ Devuelta: SÍ/NO
```

#### 4.2 Evidencias Fotográficas (OBLIGATORIAS)

```
FOTOS REQUERIDAS POR TIPO DE ORDEN

Instalación GPS:
├─ 1. Vista general vehículo (4 ángulos)
├─ 2. Ubicación dispositivo instalado
├─ 3. Conexiones eléctricas
├─ 4. Cableado oculto
├─ 5. SIM card instalada
├─ 6. Prueba de encendido (LED)
└─ 7. Pantalla activación plataforma

Retiro GPS:
├─ 1. Ubicación antes retiro
├─ 2. Dispositivo retirado
├─ 3. Estado conexiones
└─ 4. Zona restaurada

Mantenimiento:
├─ 1. Estado antes
├─ 2. Trabajo realizado
└─ 3. Estado después

Metadata por Foto:
├─ GPS: Latitud/Longitud (precisión)
├─ Timestamp: Fecha/Hora exacta
├─ Usuario: Técnico que subió
└─ Tamaño/Formato: PNG/JPG, KB
```

### Fase 5: Checklist AFTER (TÉCNICO)

**Repite inspección completa** de los mismos ítems del checklist BEFORE para documentar el estado del vehículo al finalizar el trabajo.

**Observaciones Adicionales:**

```
OBSERVACIONES FINALES TÉCNICO:
_________________________________________
Trabajo realizado: ______________________
Tiempo empleado: ________________________
Materiales usados: ______________________
```

### Fase 6: Firma de Conformidad (CLIENTE)

```
FIRMA DIGITAL CLIENTE
├─ Tipo: CONFORMIDAD
├─ Nombre firmante: __________
├─ DNI/Documento: ____________
├─ Cargo/Relación: ___________
├─ Observaciones cliente: ____
│
├─ METADATA AUTOMÁTICA:
│   ├─ Hash SHA256: [Integridad]
│   ├─ IP Address: __________
│   ├─ User-Agent: __________
│   ├─ GPS: Lat/Lng
│   ├─ Timestamp: ___________
│   └─ Dispositivo: _________
│
└─ Archivo PNG: storage/private/signatures/
```

### Fase 7: Finalización (TÉCNICO)

```php
$workOrder->finalizar();

// Validaciones automáticas:
✓ Checklist BEFORE completo
✓ Checklist AFTER completo
✓ Firma de conformidad registrada
✓ Dispositivos registrados (si aplica)
✓ Mínimo de fotos según tipo

// Acciones:
- Estado: FINALIZADO
- fecha_finalizacion: now()
- Notifica admin finalización
- Genera PDF automático
- Envía email cliente con reporte
```

### Fase 8: Cierre Administrativo (ADMIN)

```php
$workOrder->cerrar();

// Acciones irreversibles:
- bloqueado = TRUE
- fecha_cerrado = now()
- closed_by = admin_user_id
- Estado permanente
- Ya NO editable

// Reportes generados:
├─ PDF completo con fotos
├─ Certificado de instalación
├─ Activity log completo
└─ Archivos preservados 7 años
```

---

## 📊 Modelos y Relaciones

### WorkOrder (Modelo Principal)

```php
// Relaciones
- belongsTo: WorkOrderType (tipo)
- belongsTo: Vehiculos (vehiculo)
- belongsTo: Clientes (cliente)
- belongsTo: User (tecnico)
- belongsTo: User (creador)
- hasMany: DeviceHistory (deviceHistory)
- hasMany: WorkOrderChecklist (checklists)
- hasMany: WorkOrderPhoto (photos)
- hasMany: WorkOrderSignature (signatures)
- hasMany: WorkOrderAccessory (accessories)

// Campos Clave
- codigo: string (OT25-000001) AUTO
- uuid: string AUTO
- estado: WorkOrderStatus ENUM
- fecha_programada: datetime
- fecha_inicio: datetime nullable
- fecha_finalizacion: datetime nullable
- fecha_cerrado: datetime nullable
- bloqueado: boolean default(false)
- tipo_data: json (snapshot del tipo)
- metadata: json (datos adicionales)
- observaciones_inicial: text
- observaciones_final: text
```

### DeviceHistory (Inmutable)

```php
// CRÍTICO: NUNCA UPDATE/DELETE
// Solo INSERT (append-only)

campos:
- work_order_id
- vehiculo_id
- accion: 'instalacion'|'retiro'
- imei_instalado: string nullable
- imei_retirado: string nullable
- iccid_instalado: string nullable
- iccid_retirado: string nullable
- ubicacion_dispositivo: string
- modelo_dispositivo: string
- observaciones: text
- metadata: json
```

### WorkOrderChecklist

```php
campos:
- work_order_id
- checklist_template_id
- fase: 'before'|'after'
- resultado: ChecklistResultado ENUM
- observaciones: text nullable
- inspeccionado_by: user_id
- inspeccionado_at: datetime

métodos:
- marcarComoOk()
- marcarComoObservado($obs)
- marcarComoNoAplica()
```

### ChecklistTemplate (Catálogo)

```php
// Plantilla reutilizable

campos:
- nombre: string
- descripcion: text
- categoria: ChecklistCategoria ENUM
- requiere_foto: boolean
- orden: integer
- is_active: boolean
- metadata: json

categorías:
VEHICULO, TABLERO, LUCES, ACCESORIOS,
MOTOR, NEUMATICOS, DOCUMENTOS, OTROS
```

---

## 🚦 Estados de las Órdenes

### Estado: PENDIENTE

```
Características:
- Recién creada
- Técnico notificado
- Esperando inicio
- Editable completamente
- Puede cancelarse sin restricciones

Acciones permitidas:
✓ Editar asignación
✓ Cambiar técnico
✓ Modificar fecha
✓ Cancelar
✓ Iniciar trabajo
```

### Estado: EN_PROCESO

```
Características:
- Técnico trabajando
- Checklist en progreso
- Evidencias subiendo
- Edición limitada
- No cancelable directamente

Acciones permitidas:
✓ Completar checklist
✓ Subir fotos
✓ Registrar dispositivos
✓ Firmar conformidad
✓ Finalizar trabajo
✗ Cancelar (requiere motivo)
```

### Estado: FINALIZADO

```
Características:
- Trabajo completado
- Esperando cierre admin
- Cliente firmó conformidad
- Evidencias completas
- Edición muy limitada

Acciones permitidas:
✓ Cerrar orden (admin)
✓ Ver/descargar PDF
✓ Agregar notas administrativas
✗ Modificar checklist
✗ Eliminar evidencias
```

### Estado: CANCELADO

```
Características:
- Orden cancelada con motivo
- No se completó trabajo
- Preserva datos parciales
- No editable
- Auditable

Motivos comunes:
- Cliente no disponible
- Falta de materiales
- Vehículo no corresponde
- Error en asignación
- Solicitud cliente
```

---

## ✅ Sistema de Checklist

### Plantillas Predefinidas

```sql
-- Seeders incluidos

INSERT INTO checklist_templates VALUES
-- LUCES
(1, 'Luces Delanteras', 'Faros principales, direccionales', 'LUCES', true, 1),
(2, 'Luces Posteriores', 'Stop, retroceso, placa', 'LUCES', true, 2),

-- TABLERO
(3, 'Tablero - Estado', 'Instrumentos, testigos', 'TABLERO', true, 3),
(4, 'Alarmas', 'Funcionamiento alarmas', 'TABLERO', false, 4),
(5, 'Claxon Eléctrico', 'Operatividad', 'TABLERO', false, 5),

-- VEHICULO
(6, 'Pintura - Estado', 'Carrocería general', 'VEHICULO', true, 6),
(7, 'Interior - Tapiz', 'Asientos, tapicería', 'VEHICULO', false, 7),
(8, 'Limpieza', 'Estado limpieza general', 'VEHICULO', false, 8),

-- ACCESORIOS
(9, 'Llanta de Repuesto', 'Presencia y estado', 'ACCESORIOS', false, 9),
(10, 'Gata/Llave', 'Herramientas emergencia', 'ACCESORIOS', false, 10),
(11, 'Tapa Tanque Combustible', 'Presencia y cierre', 'ACCESORIOS', false, 11),
(12, 'Máscara Radio', 'Estado', 'ACCESORIOS', false, 12),
(13, 'Espejos', 'Integridad', 'ACCESORIOS', false, 13),
(14, 'Emblemas', 'Logos, insignias', 'ACCESORIOS', false, 14),
(15, 'Antena', 'Presencia', 'ACCESORIOS', false, 15),

-- DOCUMENTOS
(16, 'Tarjeta Propiedad', 'Original, copia', 'DOCUMENTOS', false, 16),
(17, 'SOAT', 'Vigencia', 'DOCUMENTOS', false, 17),

-- OTROS
(18, 'Gavetas', 'Compartimientos', 'OTROS', false, 18),
(19, 'Brazos y Plumillas', 'Limpia parabrisas', 'OTROS', false, 19),
(20, 'Pestillos Mecánicos', 'Chapas, cerraduras', 'OTROS', false, 20),
(21, 'Pestillos Eléctricos', 'Seguros eléctricos', 'OTROS', false, 21),
(22, 'Pisos - Jebes', 'Alfombras goma', 'OTROS', false, 22);
```

### Ejecución del Checklist

```php
// Al iniciar orden, crear checklist from templates
$templates = ChecklistTemplate::active()->orderBy('orden')->get();

foreach ($templates as $template) {
    WorkOrderChecklist::create([
        'work_order_id' => $workOrder->id,
        'checklist_template_id' => $template->id,
        'fase' => 'before', // Luego 'after'
        'resultado' => null, // Pendiente
    ]);
}

// Técnico completa
$checklist->marcarComoObservado('Pintura rayada costado izquierdo');
$checklist->marcarComoOk();
$checklist->marcarComoNoAplica();
```

---

## 📱 Notificaciones y Eventos

### Push Notifications (Firebase)

```php
// Al crear orden
Notification::send($tecnico, new NuevaOrdenAsignada($workOrder));

// Payload:
{
  "title": "Nueva Orden Asignada",
  "body": "OT25-000123 - Instalación GPS",
  "data": {
    "work_order_id": 123,
    "tipo": "instalacion",
    "vehiculo_placa": "ABC-123",
    "cliente": "Transportes SAC",
    "fecha_programada": "2025-12-24 09:00"
  },
  "actions": ["VER", "ACEPTAR"]
}
```

### Eventos Socket (Laravel Echo)

```javascript
// App móvil escucha
Echo.private(`user.${userId}`)
    .listen("WorkOrderCreated", (e) => {
        // Mostrar notificación in-app
        // Actualizar lista de órdenes
        // Badge contador
    })
    .listen("WorkOrderUpdated", (e) => {
        // Refresh detalles
    });
```

### Emails Automáticos

```
Trigger: Orden creada
├─ Para: Técnico
├─ CC: Admin
└─ Contenido: Detalles orden, fecha, ubicación

Trigger: Orden finalizada
├─ Para: Cliente
├─ CC: Admin
└─ Contenido: PDF reporte, certificado

Trigger: Orden vencida
├─ Para: Admin, Técnico
└─ Contenido: Alerta orden sin completar
```

---

## 🔐 Roles y Permisos

### Administrador

```
✓ Crear órdenes
✓ Asignar técnicos
✓ Ver todas las órdenes
✓ Cerrar órdenes finalizadas
✓ Cancelar órdenes
✓ Editar tipos de órdenes
✓ Gestionar plantillas checklist
✓ Acceso reportes completos
✓ Exportar datos
```

### Técnico

```
✓ Ver órdenes asignadas
✓ Iniciar orden
✓ Completar checklist
✓ Subir evidencias
✓ Registrar dispositivos
✓ Solicitar firma cliente
✓ Finalizar orden
✗ Cerrar orden
✗ Cancelar sin motivo
✗ Editar después cierre
```

### Cliente (Portal)

```
✓ Ver órdenes propias
✓ Firmar conformidad
✓ Descargar certificados
✓ Consultar historial
✗ Editar datos técnicos
✗ Acceso info otros clientes
```

---

## 🔌 API Endpoints

### Autenticación

```
POST /api/login
POST /api/logout
POST /api/refresh-token
```

### Work Orders

```
GET    /api/work-orders              # Listar
GET    /api/work-orders/{id}         # Detalle
POST   /api/work-orders               # Crear
PUT    /api/work-orders/{id}         # Actualizar
DELETE /api/work-orders/{id}         # Cancelar

POST   /api/work-orders/{id}/iniciar
POST   /api/work-orders/{id}/finalizar
POST   /api/work-orders/{id}/cerrar
POST   /api/work-orders/{id}/cancelar
```

### Checklist

```
GET    /api/work-orders/{id}/checklist
POST   /api/work-orders/{id}/checklist/{checklistId}/completar
```

### Evidencias

```
GET    /api/work-orders/{id}/fotos
POST   /api/work-orders/{id}/fotos/subir
DELETE /api/work-orders/{id}/fotos/{fotoId}
```

### Firmas

```
POST   /api/work-orders/{id}/firmar
GET    /api/work-orders/{id}/firmas
```

### Dispositivos

```
GET    /api/work-orders/{id}/dispositivos
POST   /api/work-orders/{id}/dispositivos/registrar
```

---

## 📈 Reportes y Analytics

### Dashboard Admin

```
ESTADÍSTICAS EN TIEMPO REAL
├─ Órdenes pendientes: COUNT
├─ Órdenes en proceso: COUNT
├─ Órdenes finalizadas hoy: COUNT
├─ Órdenes vencidas: COUNT (fecha_programada < now)
│
TÉCNICOS
├─ Órdenes por técnico
├─ Tiempo promedio ejecución
├─ Rating promedio
│
TIPOS DE ORDEN
├─ Más solicitados
├─ Tiempo promedio por tipo
└─ Costos promedio
```

### Reportes Exportables

```
PDF: Orden completa
├─ Datos básicos
├─ Checklist before/after
├─ Fotos evidencia
├─ Firmas digitales
├─ Historial dispositivos
└─ Activity log

Excel: Bulk export
├─ Rango fechas
├─ Por técnico
├─ Por tipo orden
└─ Por cliente
```

---

## 🛡️ Seguridad y Auditabilidad

### Activity Log (Spatie)

```php
// Todos los cambios quedan registrados
"created work_order OT25-000001"
"updated status: PENDIENTE → EN_PROCESO"
"checklist item #5 marked as OBSERVADO"
"photo uploaded by Técnico Juan"
"signature recorded for Cliente ABC"
"work order closed by Admin"
```

### Firma Digital con Hash

```php
// Integridad criptográfica
$signature->hash = hash('sha256', $fileContent);

// Verificación posterior
$signature->verificarIntegridad(); // true/false
```

### Soft Deletes vs Bloqueado

```php
// Soft delete: Recuperable
$workOrder->delete(); // deleted_at set

// Bloqueado: Permanente
$workOrder->cerrar(); // bloqueado = TRUE, NO editable
```

---

## 📋 Checklist de Implementación

### Backend

-   [x] Migraciones tablas
-   [x] Modelos y relaciones
-   [x] Enums y casts
-   [x] Observers
-   [x] Seeders plantillas
-   [x] API Controllers
-   [x] Validaciones Form Requests
-   [ ] Notificaciones Firebase
-   [ ] Eventos Broadcasting
-   [ ] Jobs asíncronos
-   [ ] Tests unitarios

### Frontend Web

-   [x] Vista index con tabla
-   [x] Modal crear orden
-   [ ] Modal editar orden
-   [ ] Vista detalle orden
-   [ ] Componente checklist
-   [ ] Componente subir fotos
-   [ ] Componente firmas
-   [ ] Dashboard estadísticas

### App Móvil

-   [ ] Login técnicos
-   [ ] Lista órdenes asignadas
-   [ ] Detalle orden
-   [ ] Checklist interactivo
-   [ ] Cámara evidencias
-   [ ] Registro dispositivos
-   [ ] Captura firma cliente
-   [ ] Offline mode
-   [ ] Sync al reconectar

---

## 🔧 Configuración Inicial

### 1. Ejecutar Migraciones

```bash
php artisan migrate
```

### 2. Ejecutar Seeders

```bash
php artisan db:seed --class=WorkOrderTypeSeeder
php artisan db:seed --class=ChecklistTemplateSeeder
```

### 3. Configurar Permisos

```bash
php artisan permission:create-role admin
php artisan permission:create-role tecnico
php artisan permission:create-role cliente
```

### 4. Configurar Storage

```bash
php artisan storage:link
mkdir storage/app/private/signatures
mkdir storage/app/private/photos
chmod -R 775 storage/app/private
```

### 5. Configurar Firebase (Notificaciones)

```env
FIREBASE_CREDENTIALS=path/to/firebase-credentials.json
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

### 6. Configurar Broadcasting

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-key
PUSHER_APP_SECRET=your-secret
PUSHER_APP_CLUSTER=mt1
```

---

## 📞 Soporte y Mantenimiento

### Logs Importantes

```
storage/logs/laravel.log       # Errores generales
storage/logs/work-orders.log   # Específico módulo
storage/logs/notifications.log # Push notifications
```

### Comandos Útiles

```bash
# Limpiar órdenes antiguas (archivadas)
php artisan work-orders:archive --days=365

# Regenerar PDFs
php artisan work-orders:regenerate-pdfs

# Verificar integridad firmas
php artisan signatures:verify-integrity

# Reportes automáticos
php artisan work-orders:daily-report
```

---

## 🎓 Capacitación

### Para Administradores (2 horas)

1. Creación de tipos de órdenes
2. Asignación de técnicos
3. Monitoreo en tiempo real
4. Cierre y archivo de órdenes
5. Generación de reportes

### Para Técnicos (3 horas)

1. App móvil: Login y sincronización
2. Aceptar y comenzar orden
3. Completar checklist detallado
4. Subir evidencias con GPS
5. Registrar dispositivos
6. Solicitar y capturar firmas
7. Finalizar orden

### Para Clientes (30 minutos)

1. Acceso portal web
2. Consultar órdenes
3. Firmar conformidad digital
4. Descargar certificados

---

## 📚 Referencias

-   [Documentación Laravel](https://laravel.com/docs)
-   [Livewire 3](https://livewire.laravel.com)
-   [Spatie Activity Log](https://spatie.be/docs/laravel-activitylog)
-   [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
-   [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging)

---

**Versión:** 1.0.0  
**Última actualización:** 24 de diciembre de 2025  
**Autor:** Sistema Talentus
