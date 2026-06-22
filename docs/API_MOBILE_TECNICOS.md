# API Móvil — Talentus Técnicos

Documentación de la API REST para la aplicación móvil de técnicos de campo.

- **Base URL:** `https://{dominio}/api`
- **Formato:** JSON
- **Autenticación:** Bearer Token (Laravel Sanctum)
- **Zona horaria:** `America/Lima` (PEN)

---

## Autenticación

### Cómo funciona

La API usa **Laravel Sanctum con tokens de acceso personal**. El flujo es:

1. El técnico llama a `POST /api/auth/login` con sus credenciales.
2. El servidor valida que el usuario tenga el rol `tecnico`.
3. Devuelve un **Bearer Token** que debe incluirse en todas las peticiones protegidas.
4. Al cerrar sesión, el token se revoca (`POST /api/auth/logout`).

```
Login → Bearer Token → todas las peticiones siguientes llevan:
  Header: Authorization: Bearer {token}
```

> **Tokens:** No expiran por defecto. Se recomienda guardarlos de forma segura (Keychain en iOS, EncryptedSharedPreferences en Android).

---

## 1. Autenticación

### `POST /api/auth/login`

Autentica al técnico y retorna el Bearer Token.

**No requiere autenticación previa.**

**Body (JSON):**

| Campo         | Tipo   | Requerido | Descripción                                                       |
| ------------- | ------ | --------- | ----------------------------------------------------------------- |
| `email`       | string | ✅        | Email del técnico                                                 |
| `password`    | string | ✅        | Contraseña                                                        |
| `device_name` | string | ❌        | Nombre del dispositivo (ej: "Samsung S24"). Default: `mobile-app` |

**Ejemplo de petición:**

```json
{
    "email": "juan.perez@empresa.com",
    "password": "mi_contraseña",
    "device_name": "Samsung S24 Ultra"
}
```

**Respuesta exitosa `200`:**

```json
{
    "success": true,
    "token": "1|abcdef123456...",
    "user": {
        "id": 5,
        "name": "Juan Pérez",
        "email": "juan.perez@empresa.com",
        "numero_documento": "12345678",
        "telefono": "987654321",
        "ciudad_id": 2,
        "profile_photo_url": "https://..."
    }
}
```

**Errores posibles:**

| Código | Mensaje                                                               |
| ------ | --------------------------------------------------------------------- |
| `401`  | `"Credenciales inválidas"`                                            |
| `403`  | `"Acceso restringido: solo técnicos pueden usar la aplicación móvil"` |
| `422`  | Errores de validación del formulario                                  |

---

### `POST /api/auth/logout`

Revoca el token actual del dispositivo.

**Requiere:** `Authorization: Bearer {token}`

**Respuesta `200`:**

```json
{
    "success": true,
    "message": "Sesión cerrada correctamente"
}
```

---

### `GET /api/auth/me`

Retorna el perfil completo del técnico autenticado, incluyendo roles y permisos.

**Requiere:** `Authorization: Bearer {token}`

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "id": 5,
        "name": "Juan Pérez",
        "email": "juan.perez@empresa.com",
        "numero_documento": "12345678",
        "telefono": "987654321",
        "ciudad": "Lima",
        "ciudad_id": 2,
        "wa_group_id": "120363...",
        "profile_photo_url": "https://...",
        "roles": ["tecnico"],
        "permisos": ["ver-work_order", "editar-work_order"]
    }
}
```

---

## Cabeceras requeridas en todas las peticiones autenticadas

```http
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

## 2. Órdenes de Trabajo

### `GET /api/work-orders/stats`

Resumen de órdenes del técnico autenticado. Útil para el dashboard de la app.

**No requiere params.** Siempre usa el técnico autenticado.

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "pendientes": 3,
        "en_proceso": 1,
        "total_activas": 4,
        "finalizadas_hoy": 2,
        "finalizadas_mes": 18
    }
}
```

---

### `GET /api/work-orders`

Lista las órdenes de trabajo asignadas al técnico autenticado.

> **Auto-scope:** Si no se pasa `tecnico_id`, la API filtra automáticamente por el técnico autenticado. Solo se puede ver los propios.

**Query params:**

| Parámetro     | Tipo    | Descripción                                                  |
| ------------- | ------- | ------------------------------------------------------------ |
| `estado`      | string  | `pendiente`, `en_proceso`, `finalizado`, `cancelado`         |
| `tecnico_id`  | integer | Filtrar por técnico (default: técnico autenticado)           |
| `search`      | string  | Busca por código OT, placa del vehículo o título de proyecto |
| `fecha_desde` | date    | Filtrar desde esta fecha programada (`YYYY-MM-DD`)           |
| `fecha_hasta` | date    | Filtrar hasta esta fecha programada (`YYYY-MM-DD`)           |
| `per_page`    | integer | Resultados por página (min: 5, max: 100, default: 15)        |

**Ejemplo:**

```
GET /api/work-orders?estado=pendiente&per_page=10
GET /api/work-orders?fecha_desde=2026-06-01&fecha_hasta=2026-06-30
Authorization: Bearer {token}
```

**Respuesta `200` — orden individual:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 42,
                "codigo": "OT00042",
                "es_proyecto": false,
                "titulo_proyecto": null,
                "estado": "pendiente",
                "fecha_programada": "2026-05-12T08:00:00",
                "tipo": { "id": 1, "nombre": "Instalación GPS" },
                "vehiculo": { "id": 10, "placa": "ABC-123" },
                "cliente": { "id": 3, "razon_social": "Empresa SAC" },
                "tecnico": { "id": 5, "name": "Juan Pérez" }
            }
        ],
        "last_page": 3,
        "total": 28
    }
}
```

**Respuesta `200` — orden tipo proyecto:**

```json
{
    "id": 55,
    "codigo": "OT00055",
    "es_proyecto": true,
    "titulo_proyecto": "Mantenimiento flota Arequipa",
    "estado": "en_proceso",
    "vehiculo": null,
    "cliente": null,
    "items_count": 12,
    "tipo": { "id": 2, "nombre": "Mantenimiento" },
    "tecnico": { "id": 5, "name": "Juan Pérez" }
}
```

---

### `GET /api/work-orders/{id}`

Retorna el detalle completo de una orden con todas sus relaciones.

**Relaciones incluidas (orden individual):** tipo, vehículo, cliente, técnico, creador, historial de dispositivos, checklist, fotos, firmas, accesorios.

**Relaciones incluidas (orden proyecto):** todo lo anterior **más** `items` (array de `WorkOrderItem`). Los campos `vehiculo` y `cliente` serán `null`.

**Respuesta `200` — orden individual:**

```json
{
    "success": true,
    "data": {
        "id": 42,
        "codigo": "OT00042",
        "es_proyecto": false,
        "titulo_proyecto": null,
        "estado": "en_proceso",
        "bloqueado": false,
        "fecha_programada": "2026-05-12T08:00:00",
        "fecha_inicio": "2026-05-12T08:15:00",
        "fecha_finalizacion": null,
        "observaciones": "Instalar en tablero central",
        "sector": "SUTRAN",
        "plan": "GPS Básico",
        "contacto": "Carlos Ríos — Administrador — Tel: 999000111",
        "metadata": { "accesorios": ["buzzer", "corte_motor"] },
        "tipo": { "id": 1, "nombre": "Instalación GPS" },
        "vehiculo": { "id": 10, "placa": "ABC-123" },
        "cliente": { "id": 3, "razon_social": "Empresa SAC" },
        "tecnico": { "id": 5, "name": "Juan Pérez" },
        "checklists": [],
        "photos": [],
        "signatures": [],
        "accessories": [],
        "deviceHistory": []
    }
}
```

**Respuesta `200` — orden tipo proyecto:**

```json
{
    "success": true,
    "data": {
        "id": 55,
        "codigo": "OT00055",
        "es_proyecto": true,
        "titulo_proyecto": "Mantenimiento flota Arequipa",
        "estado": "en_proceso",
        "bloqueado": false,
        "vehiculo": null,
        "cliente": null,
        "tipo": { "id": 2, "nombre": "Mantenimiento" },
        "tecnico": { "id": 5, "name": "Juan Pérez" },
        "items": [
            {
                "id": 101,
                "placa": "ABC-123",
                "estado": "pendiente",
                "imei": null,
                "numero_sim": null,
                "notas": "Cambio de chip urgente",
                "orden": 0,
                "tipo": { "id": 2, "nombre": "Mantenimiento" },
                "vehiculo": { "id": 10, "placa": "ABC-123", "marca": "VOLVO" }
            }
        ],
        "photos": [],
        "signatures": []
    }
}
```

> **Nota:** Para órdenes de tipo proyecto, los campos `checklist`, `deviceHistory` y `accessories` operan a nivel de la orden general. La asignación de IMEI/SIM por vehículo se gestiona en cada `WorkOrderItem` (ver sección 9).

---

## 3. Ciclo de vida de la Orden

### Estados y transiciones

```
PENDIENTE ──► EN_PROCESO ──► FINALIZADO ──► CERRADO (bloqueado=true)
                │
                └──► CANCELADO
```

### `POST /api/work-orders/{id}/iniciar`

Cambia el estado de `pendiente` a `en_proceso`. Registra `fecha_inicio`.

**Requiere:** orden en estado `pendiente`.

**Respuesta `200`:**

```json
{ "success": true, "message": "Orden de trabajo iniciada correctamente", "data": { ... } }
```

**Error `422`:** `"Solo se pueden iniciar órdenes pendientes"`

---

### `POST /api/work-orders/{id}/finalizar`

Cambia el estado de `en_proceso` a `finalizado`. Registra `fecha_finalizacion`.

**Requiere:** orden en estado `en_proceso` **y** que exista una firma de tipo `conformidad`.

**Body (JSON):**

```json
{
    "observaciones_final": "Trabajo completado sin observaciones"
}
```

**Error `422`:** `"Se requiere la firma de conformidad del cliente"`

---

### `POST /api/work-orders/{id}/cerrar`

Cierra y bloquea permanentemente la orden (`bloqueado = true`). No permite más cambios.

**Requiere:** orden en estado `finalizado`.

---

### `POST /api/work-orders/{id}/cancelar`

Cancela la orden. No aplica a órdenes bloqueadas.

**Body (JSON):**

```json
{
    "motivo_cancelacion": "Cliente canceló el servicio"
}
```

> `motivo_cancelacion` es **requerido**.

---

## 4. Checklist de Inspección

El checklist tiene dos fases:

- `before` — inspección **antes** del trabajo
- `after` — inspección **después** del trabajo

Resultados posibles por ítem:

- `ok` — Conforme
- `observado` — Con observación (requiere descripción)
- `no_aplica` — No aplica al vehículo

---

### `GET /api/work-orders/templates/checklist`

Obtiene las plantillas de checklist disponibles agrupadas por categoría.

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "CARROCERÍA": [
            {
                "id": 1,
                "nombre": "Estado de parabrisas",
                "descripcion": "Verificar fisuras o roturas"
            }
        ],
        "MOTOR": [
            {
                "id": 5,
                "nombre": "Nivel de aceite",
                "descripcion": "Verificar en frío"
            }
        ]
    }
}
```

---

### `GET /api/work-orders/{id}/checklist`

Lista los ítems de checklist completados de la orden, agrupados por fase.

---

### `POST /api/work-orders/{id}/checklist`

Guarda o actualiza el resultado de un ítem del checklist.

**Body (JSON):**

```json
{
    "checklist_template_id": 1,
    "fase": "before",
    "resultado": "observado",
    "observaciones": "Fisura en esquina inferior derecha del parabrisas"
}
```

| Campo       | Valores aceptados              |
| ----------- | ------------------------------ |
| `fase`      | `before`, `after`              |
| `resultado` | `ok`, `observado`, `no_aplica` |

---

## 5. Evidencia Fotográfica

### `GET /api/work-orders/{id}/fotos`

Lista todas las fotos de la orden con metadata.

---

### `POST /api/work-orders/{id}/fotos`

Sube una foto como evidencia. La petición debe ser `multipart/form-data`.

**Campos:**

| Campo                     | Tipo    | Requerido | Descripción                         |
| ------------------------- | ------- | --------- | ----------------------------------- |
| `foto`                    | file    | ✅        | Imagen (JPG/PNG, máx 5MB)           |
| `tipo`                    | string  | ✅        | `checklist`, `general`, `evidencia` |
| `fase`                    | string  | ❌        | `before`, `after`, `proceso`        |
| `work_order_checklist_id` | integer | ❌        | ID del ítem checklist asociado      |
| `descripcion`             | string  | ❌        | Descripción breve                   |
| `latitude`                | number  | ❌        | Latitud GPS del dispositivo         |
| `longitude`               | number  | ❌        | Longitud GPS del dispositivo        |

**Ejemplo petición (multipart):**

```
POST /api/work-orders/42/fotos
Authorization: Bearer {token}
Content-Type: multipart/form-data

foto=<archivo_binario>
tipo=evidencia
fase=proceso
latitude=-12.046374
longitude=-77.042793
descripcion=Dispositivo GPS instalado en tablero
```

---

### `DELETE /api/work-orders/fotos/{photo_id}`

Elimina una foto (solo si la orden no está bloqueada).

---

### `GET /api/work-orders/fotos/{photo_id}/download`

Descarga el archivo de la foto desde storage privado.

---

## 6. Firmas Digitales

Las firmas se almacenan como imágenes PNG en storage privado con un **hash SHA256** para verificación de integridad. Incluyen metadata legal: IP, User-Agent, coordenadas GPS, fecha/hora.

**Tipos de firma:**

| Tipo          | Cuándo se usa                                                                   |
| ------------- | ------------------------------------------------------------------------------- |
| `recepcion`   | Al inicio del trabajo (firma el técnico)                                        |
| `conformidad` | Al terminar (firma el cliente/conductor). **Requerida para finalizar la orden** |

---

### `GET /api/work-orders/{id}/firmas`

Lista las firmas de la orden con verificación de integridad.

---

### `POST /api/work-orders/{id}/firmas`

Guarda una firma digital en formato Base64.

**Body (JSON):**

```json
{
    "tipo": "conformidad",
    "firma_base64": "data:image/png;base64,iVBORw0KGgoAAAANS...",
    "nombre_firmante": "Carlos Ríos",
    "tipo_firmante": "conductor",
    "documento_firmante": "12345678",
    "latitude": -12.046374,
    "longitude": -77.042793
}
```

| Campo           | Valores aceptados                                 |
| --------------- | ------------------------------------------------- |
| `tipo`          | `recepcion`, `conformidad`                        |
| `tipo_firmante` | `conductor`, `cliente`, `encargado`, `supervisor` |

> Solo puede existir **una firma por tipo** en cada orden. Si ya existe, retorna `422`.

---

### `GET /api/work-orders/firmas/{signature_id}/download`

Descarga el archivo PNG de la firma.

---

## 7. Historial de Dispositivos GPS / SIM

Registro **inmutable** (append-only) de todas las instalaciones y retiros de dispositivos.

### `GET /api/work-orders/{id}/dispositivos`

Lista el historial de dispositivos asociados a la orden.

---

### `POST /api/work-orders/{id}/dispositivos`

Registra la instalación o retiro de un dispositivo GPS y/o SIM card.

**Body (JSON):**

```json
{
    "dispositivo_id": 15,
    "imei": "123456789012345",
    "accion_imei": "instalado",
    "sim_card_id": 8,
    "iccid": "8951140...",
    "numero_linea": "987000111",
    "accion_sim": "instalado",
    "dispositivo_anterior_id": null,
    "sim_card_anterior_id": null,
    "observaciones": "Instalado en tablero central"
}
```

| Campo         | Valores aceptados                                 |
| ------------- | ------------------------------------------------- |
| `accion_imei` | `instalado`, `retirado`, `reemplazado`, `ninguna` |
| `accion_sim`  | `instalado`, `retirado`, `reemplazado`, `ninguna` |

> Usar `"ninguna"` cuando no se hace acción sobre ese componente (ej: solo instalar SIM sin GPS).

---

## 8. Accesorios Instalados

### `GET /api/work-orders/{id}/accesorios`

Lista los accesorios con el total calculado.

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 3,
                "nombre": "Buzzer - Alerta Sonora",
                "cantidad": 1,
                "precio_unitario": "45.00",
                "subtotal": "45.00",
                "accion": "instalado"
            }
        ],
        "total": 45.0
    }
}
```

---

### `POST /api/work-orders/{id}/accesorios`

Agrega un accesorio instalado o retirado. El subtotal se calcula automáticamente.

**Body (JSON):**

```json
{
    "producto_id": 7,
    "nombre": "Buzzer - Alerta Sonora",
    "descripcion": "Alarma sonora de 90dB",
    "cantidad": 1,
    "serial": "BZZ-2026-001",
    "accion": "instalado",
    "precio_unitario": 45.0
}
```

| Campo    | Valores aceptados                      |
| -------- | -------------------------------------- |
| `accion` | `instalado`, `retirado`, `reemplazado` |

---

### `DELETE /api/work-orders/accesorios/{accessory_id}`

Elimina un accesorio (solo si la orden no está bloqueada).

---

## 9. Ítems del Proyecto (WorkOrderItem)

Disponibles **únicamente** cuando `es_proyecto = true`. Cada ítem representa un vehículo dentro de la orden de trabajo grupal.

### Estructura de un WorkOrderItem

| Campo                | Tipo    | Descripción                                             |
| -------------------- | ------- | ------------------------------------------------------- |
| `id`                 | integer | ID del ítem                                             |
| `placa`              | string  | Placa del vehículo                                      |
| `estado`             | string  | `pendiente`, `completado`, `omitido`                    |
| `imei`               | string  | IMEI del dispositivo GPS asignado (null si no asignado) |
| `numero_sim`         | string  | Número de SIM asignada (null si no asignada)            |
| `notas`              | string  | Notas específicas para este vehículo                    |
| `orden`              | integer | Posición en la lista                                    |
| `work_order_type_id` | integer | ID del tipo de trabajo (FK a `work_order_types`)        |
| `tipo`               | object  | Relación: `{ id, nombre }`                              |
| `vehiculo`           | object  | Relación: datos del vehículo si existe en el sistema    |
| `cliente_nombre`     | string  | Nombre de la empresa del vehículo (desnormalizado)      |

> Retorna `422` si se llama sobre una orden que no es proyecto.

---

### `GET /api/work-orders/{id}/items`

Lista todos los ítems del proyecto con contadores de progreso.

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 101,
                "placa": "ABC-123",
                "estado": "completado",
                "imei": "354689112345678",
                "numero_sim": "8951140000123456789",
                "notas": "Cambio de chip",
                "orden": 0,
                "tipo": { "id": 2, "nombre": "Mantenimiento" },
                "vehiculo": { "id": 10, "placa": "ABC-123", "marca": "VOLVO" }
            }
        ],
        "total": 12,
        "completados": 5,
        "omitidos": 1,
        "pendientes": 6,
        "progreso": 42
    }
}
```

---

### `POST /api/work-orders/{id}/items`

Agrega un vehículo al proyecto. Si la placa existe en el sistema, se vincula automáticamente.

**Body (JSON):**

```json
{
    "placa": "ABC-123",
    "work_order_type_id": 2,
    "notas": "Revisión de antena GPS"
}
```

| Campo                | Tipo    | Requerido | Descripción                                    |
| -------------------- | ------- | --------- | ---------------------------------------------- |
| `placa`              | string  | ✅        | Placa del vehículo (se convierte a MAYÚSCULAS) |
| `work_order_type_id` | integer | ✅        | ID del tipo de trabajo (de `WorkOrderType`)    |
| `notas`              | string  | ❌        | Observaciones específicas para este vehículo   |

**Respuesta `201`:**

```json
{
  "success": true,
  "message": "Unidad ABC-123 agregada al proyecto.",
  "data": { ... }
}
```

---

### `PATCH /api/work-orders/{id}/items/{item_id}/estado`

Cambia el estado del ítem de forma cíclica: `pendiente → completado → omitido → pendiente`.

No requiere body. Cada llamada avanza al siguiente estado.

**Respuesta `200`:**

```json
{
  "success": true,
  "data": { "id": 101, "estado": "completado", ... }
}
```

---

### `PATCH /api/work-orders/{id}/items/{item_id}/dispositivo`

Asigna el IMEI del GPS y/o el número de SIM a un vehículo específico del proyecto.

**Body (JSON):**

```json
{
    "imei": "354689112345678",
    "numero_sim": "8951140000123456789"
}
```

| Campo        | Tipo   | Requerido | Descripción                 |
| ------------ | ------ | --------- | --------------------------- |
| `imei`       | string | ❌        | IMEI del GPS (máx 20 chars) |
| `numero_sim` | string | ❌        | Número ICCID/SIM (máx 22)   |

> Al menos uno de los dos campos debe enviarse. Enviar cadena vacía limpia el valor.

**Respuesta `200`:**

```json
{
  "success": true,
  "message": "Dispositivo asignado correctamente.",
  "data": { "id": 101, "imei": "354689112345678", "numero_sim": "8951140000123456789", ... }
}
```

---

### `DELETE /api/work-orders/{id}/items/{item_id}`

Elimina un vehículo del proyecto (solo si la orden no está bloqueada).

**Respuesta `200`:**

```json
{
    "success": true,
    "message": "Unidad eliminada del proyecto."
}
```

---

## 10. Tracking GPS del Técnico

El técnico envía su posición periódicamente mientras atiende una orden. El administrador puede ver la ubicación en tiempo real desde el panel web.

### `POST /api/work-orders/{id}/tracking`

Envía la posición actual del técnico. Llamar cada 60 segundos durante el trabajo.

> Solo el técnico **asignado** a la orden puede actualizar su posición. Otros técnicos reciben `403`.

**Body (JSON):**

```json
{
    "lat": -12.046374,
    "lng": -77.042793,
    "accuracy": 8.5,
    "speed": 0.0
}
```

| Campo      | Tipo   | Requerido | Descripción                     |
| ---------- | ------ | --------- | ------------------------------- |
| `lat`      | number | ✅        | Latitud (-90 a 90)              |
| `lng`      | number | ✅        | Longitud (-180 a 180)           |
| `accuracy` | number | ❌        | Precisión en metros             |
| `speed`    | number | ❌        | Velocidad en m/s                |

**Respuesta `200`:**

```json
{ "success": true }
```

---

## 11. Notificaciones Push (Firebase FCM)

### Registro del token

#### `POST /api/fcm/token`

Registra o actualiza el token FCM del dispositivo. **Llamar inmediatamente después del login y cada vez que Firebase genere un nuevo token.**

**Body (JSON):**

```json
{
    "token": "f7Jk2XmRpQb3...lmnoABC"
}
```

**Respuesta `200`:**

```json
{
    "success": true,
    "message": "Token FCM guardado correctamente"
}
```

---

#### `DELETE /api/fcm/token`

Elimina el token FCM. Llamar al hacer logout para dejar de recibir notificaciones.

---

### Estructura de un mensaje FCM

Todos los mensajes tienen dos partes:

- **`notification`** — título y cuerpo visibles en la bandeja del sistema operativo.
- **`data`** — payload de datos que la app recibe (incluso en segundo plano). Todos los valores son `string`.

La app debe escuchar el campo **`action`** para identificar qué tipo de evento ocurrió y navegar a la pantalla correspondiente.

---

### Casos cubiertos

| # | Evento | `action` | Quién recibe |
|---|--------|----------|-------------|
| 1 | Orden asignada (nueva o reasignación) | `work_order_assigned` | Técnico nuevo |
| 2 | Orden reprogramada (cambio de fecha) | `work_order_reprogramada` | Técnico asignado |
| 3 | Orden retirada (reasignada a otro) | `work_order_retirada` | Técnico anterior |
| 4 | Orden eliminada | `work_order_eliminada` | Técnico asignado |
| 5 | Orden cancelada | `work_order_status_changed` | Técnico asignado |
| 6 | Técnico inició la orden | `work_order_status_changed` | Creador/Admin |
| 7 | Técnico finalizó la orden | `work_order_status_changed` | Creador/Admin |
| 8 | Push de prueba (desde Ajustes) | `test` | Usuario seleccionado |

---

### Caso 1 — Orden asignada (`work_order_assigned`)

Enviada cuando se crea una orden con técnico asignado, **o** cuando se reasigna a un nuevo técnico.

**Notification:**

```
Título: 🔧 Nueva Orden de Trabajo Asignada
Cuerpo:  Orden OT00042 - Instalación GPS | Vehículo: ABC-123
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "tipo":              "Instalación GPS",
    "vehiculo_placa":    "ABC-123",
    "vehiculo_id":       "10",
    "cliente_nombre":    "Empresa Transportes SAC",
    "fecha_programada":  "2026-06-12 08:00",
    "observaciones":     "Instalar en tablero central, traer buzzer",
    "action":            "work_order_assigned",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

> Para órdenes de tipo proyecto `vehiculo_placa` y `cliente_nombre` serán cadena vacía.

---

### Caso 2 — Orden reprogramada (`work_order_reprogramada`)

El administrador cambia la `fecha_programada` sin cambiar el técnico ni el estado.

**Notification:**

```
Título: 📅 Orden reprogramada
Cuerpo:  La orden OT00042 se reprogramó para 2026-06-15 10:00.
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "evento":            "reprogramada",
    "action":            "work_order_reprogramada",
    "vehiculo_placa":    "ABC-123",
    "fecha_programada":  "2026-06-15 10:00",
    "motivo":            "",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

---

### Caso 3 — Orden retirada (`work_order_retirada`)

La orden se reasignó a un técnico diferente. El técnico **anterior** recibe este aviso; el técnico **nuevo** recibe el caso 1.

**Notification:**

```
Título: ↩️ Orden reasignada
Cuerpo:  La orden OT00042 ya no está asignada a ti; fue reasignada a otro técnico.
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "evento":            "retirada",
    "action":            "work_order_retirada",
    "vehiculo_placa":    "ABC-123",
    "fecha_programada":  "2026-06-12 08:00",
    "motivo":            "",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

---

### Caso 4 — Orden eliminada (`work_order_eliminada`)

El administrador elimina la orden (soft delete). Se envía desde la cola usando un **snapshot** de los datos, por lo que el payload es válido aunque el registro ya no exista en la base de datos.

**Notification:**

```
Título: 🗑️ Orden eliminada
Cuerpo:  La orden OT00042 (ABC-123) fue eliminada.
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "evento":            "eliminada",
    "action":            "work_order_eliminada",
    "vehiculo_placa":    "ABC-123",
    "fecha_programada":  "2026-06-12 08:00",
    "motivo":            "",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

> Como la orden ya no existe, no intentes hacer `GET /api/work-orders/42` al recibir este push — simplemente retira la tarjeta de la lista local.

---

### Caso 5 — Orden cancelada (`work_order_status_changed`) → técnico

El administrador cancela una orden. El técnico asignado recibe la notificación.

**Notification:**

```
Título: ❌ Orden OT00042
Cuerpo:  Estado: en_proceso → cancelado
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "estado_anterior":   "en_proceso",
    "estado_actual":     "cancelado",
    "vehiculo_placa":    "ABC-123",
    "action":            "work_order_status_changed",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

---

### Caso 6 — Técnico inició la orden (`work_order_status_changed`) → creador

El técnico llama a `POST /api/work-orders/{id}/iniciar`. El creador/admin de la orden recibe el aviso.

**Notification:**

```
Título: 🚀 Orden OT00042
Cuerpo:  Estado: pendiente → en_proceso
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "estado_anterior":   "pendiente",
    "estado_actual":     "en_proceso",
    "vehiculo_placa":    "ABC-123",
    "action":            "work_order_status_changed",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

---

### Caso 7 — Técnico finalizó la orden (`work_order_status_changed`) → creador

El técnico llama a `POST /api/work-orders/{id}/finalizar`. El creador/admin recibe el aviso.

**Notification:**

```
Título: ✅ Orden OT00042
Cuerpo:  Estado: en_proceso → finalizado
```

**Data:**

```json
{
    "work_order_id":     "42",
    "work_order_codigo": "OT00042",
    "estado_anterior":   "en_proceso",
    "estado_actual":     "finalizado",
    "vehiculo_placa":    "ABC-123",
    "action":            "work_order_status_changed",
    "url":               "https://talentus.test/admin/work-orders/42"
}
```

---

### Caso 8 — Push de prueba (`test`)

Enviado manualmente desde **Ajustes → Credenciales Firebase** en el panel web.

**Notification:**

```
Título: 🔔 Prueba de Notificación
Cuerpo:  Esta es una notificación de prueba desde Talentus.
```

**Data:**

```json
{
    "action":      "test",
    "enviado_por": "Jhamner Sifuentes"
}
```

---

### Configuración Android requerida

Para que las notificaciones lleguen correctamente en Android, la app debe tener registrado el canal de notificaciones:

```
channel_id: "work_orders"   → órdenes de trabajo
channel_id: "general"       → notificaciones generales y de prueba
```

El campo `click_action` en todos los mensajes es `FLUTTER_NOTIFICATION_CLICK` (para Flutter). Para apps nativas Android, puede ignorarse o mapearse al `Intent` correspondiente.

---

### Flujo recomendado en la app

```
1. Al iniciar sesión:
   POST /api/fcm/token  ← registrar el token del dispositivo

2. Al recibir un push (foreground/background):
   Leer data.action y navegar según el caso:

   "work_order_assigned"      → abrir/refrescar la orden (data.work_order_id)
   "work_order_reprogramada"  → mostrar alerta con nueva fecha, refrescar orden
   "work_order_retirada"      → remover la orden de la lista del técnico
   "work_order_eliminada"     → remover la orden de la lista (NO llamar a la API)
   "work_order_status_changed"→ refrescar la orden (data.work_order_id)
   "test"                     → mostrar snackbar de confirmación

3. Al cerrar sesión:
   DELETE /api/fcm/token  ← revocar el token para no seguir recibiendo pushes
```

---

## Manejo de Errores

Todos los endpoints retornan errores con la siguiente estructura:

```json
{
    "success": false,
    "message": "Descripción del error"
}
```

**Códigos de estado:**

| Código | Significado                                        |
| ------ | -------------------------------------------------- |
| `200`  | Éxito                                              |
| `401`  | No autenticado (token inválido o expirado)         |
| `403`  | Sin permiso para realizar la acción                |
| `404`  | Recurso no encontrado                              |
| `422`  | Error de validación o regla de negocio no cumplida |
| `500`  | Error interno del servidor                         |

**Token inválido o faltante `401`:**

```json
{
    "message": "Unauthenticated."
}
```

> Al recibir `401`, redirigir al técnico a la pantalla de login.

---

## Flujo completo de una Orden de Trabajo

### Orden individual (un vehículo)

```
1. GET  /api/work-orders/stats
        → Dashboard: cuántas pendientes/activas tiene el técnico

2. GET  /api/work-orders?estado=pendiente
        → Cargar órdenes pendientes (auto-filtra por técnico autenticado)

2. GET  /api/work-orders/{id}
        → Ver detalle (verificar es_proyecto = false)

3. GET  /api/work-orders/{id}
        → Ver detalle completo (verificar es_proyecto = false)

4. POST /api/work-orders/{id}/iniciar
        → Iniciar trabajo (estado: pendiente → en_proceso)

5. GET  /api/work-orders/templates/checklist
6. POST /api/work-orders/{id}/checklist  (fase="before", repetir por ítem)
        → Checklist inicial del vehículo

7. POST /api/work-orders/{id}/fotos      (varias veces)
        → Fotos de evidencia (tipo=evidencia|checklist|general)

8. POST /api/work-orders/{id}/dispositivos
        → Registrar IMEI/SIM instalado (accion_imei=instalado, accion_sim=instalado)

9. POST /api/work-orders/{id}/accesorios  (si aplica)
        → Accesorios instalados

10. POST /api/work-orders/{id}/checklist  (fase="after", repetir por ítem)
         → Checklist final del vehículo

11. POST /api/work-orders/{id}/firmas  (tipo="recepcion")
         → Firma de recepción del técnico (opcional, buena práctica)

12. POST /api/work-orders/{id}/firmas  (tipo="conformidad")
         → Firma del cliente/conductor (REQUERIDA para finalizar)

13. POST /api/work-orders/{id}/finalizar
         → Finalizar orden (requiere firma conformidad)
         → Opcional: { "observaciones_final": "Sin novedad" }

14. [Desde el admin web] POST /api/work-orders/{id}/cerrar
         → Bloquear permanentemente
```

> **Tracking GPS:** Durante todo el proceso (pasos 4-13), enviar `POST /{id}/tracking` cada ~60 segundos.

### Orden de tipo proyecto (múltiples vehículos)

```
1. GET  /api/work-orders?estado=pendiente
        → es_proyecto=true, items_count=N (auto-filtra por técnico autenticado)

2. GET  /api/work-orders/{id}
        → vehiculo=null, cliente=null, items=[...]

3. POST /api/work-orders/{id}/iniciar
        → Iniciar trabajo del proyecto

4. GET  /api/work-orders/{id}/items
        → Ver lista de vehículos con su estado

5. Por cada vehículo:
   a. POST /api/work-orders/{id}/fotos
           → Foto de evidencia del vehículo (incluir descripción con placa)
   b. PATCH /api/work-orders/{id}/items/{item_id}/dispositivo
           → Asignar IMEI y SIM al vehículo
   c. PATCH /api/work-orders/{id}/items/{item_id}/estado
           → Marcar como completado (o omitido si no se realizó)

6. POST /api/work-orders/{id}/firmas  (tipo="conformidad")
        → Firma del responsable de la flota

7. POST /api/work-orders/{id}/finalizar
        → Finalizar cuando todos los ítems estén completados/omitidos
```

> **Para proyectos NO aplican:** checklist individual por vehículo ni el registro de dispositivos a nivel de orden (`/dispositivos`). Todo se gestiona por ítem.

---

## Resumen de endpoints

| Método       | Endpoint                                             | Auth | Descripción                            |
| ------------ | ---------------------------------------------------- | ---- | -------------------------------------- |
| `POST`       | `/api/auth/login`                                    | ❌   | Login con email/password               |
| `POST`       | `/api/auth/logout`                                   | ✅   | Cerrar sesión                          |
| `GET`        | `/api/auth/me`                                       | ✅   | Perfil del técnico                     |
| **`GET`**    | **`/api/work-orders/stats`**                         | ✅   | **Dashboard: resumen de órdenes**      |
| `GET`        | `/api/work-orders`                                   | ✅   | Listar órdenes (auto-scope al técnico) |
| `GET`        | `/api/work-orders/{id}`                              | ✅   | Detalle de orden                       |
| `PATCH`      | `/api/work-orders/{id}`                              | ✅   | Actualizar campos editables            |
| `POST`       | `/api/work-orders/{id}/iniciar`                      | ✅   | Iniciar orden                          |
| `POST`       | `/api/work-orders/{id}/finalizar`                    | ✅   | Finalizar orden                        |
| `POST`       | `/api/work-orders/{id}/cerrar`                       | ✅   | Cerrar y bloquear                      |
| `POST`       | `/api/work-orders/{id}/cancelar`                     | ✅   | Cancelar orden                         |
| `GET`        | `/api/work-orders/templates/checklist`               | ✅   | Plantillas de checklist                |
| `GET`        | `/api/work-orders/{id}/checklist`                    | ✅   | Checklist de la orden                  |
| `POST`       | `/api/work-orders/{id}/checklist`                    | ✅   | Guardar ítem de checklist              |
| `GET`        | `/api/work-orders/{id}/fotos`                        | ✅   | Listar fotos                           |
| `POST`       | `/api/work-orders/{id}/fotos`                        | ✅   | Subir foto (multipart)                 |
| `DELETE`     | `/api/work-orders/fotos/{id}`                        | ✅   | Eliminar foto                          |
| `GET`        | `/api/work-orders/fotos/{id}/download`               | ✅   | Descargar foto                         |
| `GET`        | `/api/work-orders/{id}/firmas`                       | ✅   | Listar firmas                          |
| `POST`       | `/api/work-orders/{id}/firmas`                       | ✅   | Guardar firma (base64)                 |
| `GET`        | `/api/work-orders/firmas/{id}/download`              | ✅   | Descargar firma PNG                    |
| `GET`        | `/api/work-orders/{id}/dispositivos`                 | ✅   | Historial de dispositivos GPS/SIM      |
| `POST`       | `/api/work-orders/{id}/dispositivos`                 | ✅   | Registrar IMEI/SIM (orden entera)      |
| `GET`        | `/api/work-orders/{id}/accesorios`                   | ✅   | Listar accesorios                      |
| `POST`       | `/api/work-orders/{id}/accesorios`                   | ✅   | Agregar accesorio                      |
| `DELETE`     | `/api/work-orders/accesorios/{id}`                   | ✅   | Eliminar accesorio                     |
| `GET`        | `/api/work-orders/{id}/items`                        | ✅   | Listar ítems del proyecto              |
| `POST`       | `/api/work-orders/{id}/items`                        | ✅   | Agregar vehículo al proyecto           |
| `PATCH`      | `/api/work-orders/{id}/items/{item}/estado`          | ✅   | Cambiar estado del ítem (ciclo)        |
| `PATCH`      | `/api/work-orders/{id}/items/{item}/dispositivo`     | ✅   | Asignar IMEI/SIM al ítem               |
| `DELETE`     | `/api/work-orders/{id}/items/{item}`                 | ✅   | Eliminar ítem del proyecto             |
| **`POST`**   | **`/api/work-orders/{id}/tracking`**                 | ✅   | **Enviar posición GPS del técnico**    |
| `POST`       | `/api/fcm/token`                                     | ✅   | Registrar token FCM (push)             |
| `DELETE`     | `/api/fcm/token`                                     | ✅   | Eliminar token FCM                     |
