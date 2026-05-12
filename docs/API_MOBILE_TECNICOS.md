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

### `GET /api/work-orders`

Lista las órdenes de trabajo con filtros opcionales.

**Query params:**

| Parámetro    | Tipo    | Descripción                                          |
| ------------ | ------- | ---------------------------------------------------- |
| `estado`     | string  | `pendiente`, `en_proceso`, `finalizado`, `cancelado` |
| `tecnico_id` | integer | Filtrar por técnico (usar `id` del usuario)          |
| `search`     | string  | Busca por código OT o placa del vehículo             |
| `per_page`   | integer | Resultados por página (default: 15)                  |

**Ejemplo:**

```
GET /api/work-orders?tecnico_id=5&estado=pendiente&per_page=10
Authorization: Bearer {token}
```

**Respuesta `200`:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 42,
                "codigo": "OT00042",
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

---

### `GET /api/work-orders/{id}`

Retorna el detalle completo de una orden con todas sus relaciones.

**Relaciones incluidas:** tipo, vehículo, cliente, técnico, creador, historial de dispositivos, checklist, fotos, firmas, accesorios.

**Respuesta `200`:**

```json
{
  "success": true,
  "data": {
    "id": 42,
    "codigo": "OT00042",
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
    "tipo": { ... },
    "vehiculo": { ... },
    "cliente": { ... },
    "tecnico": { ... },
    "checklists": [ ... ],
    "photos": [ ... ],
    "signatures": [ ... ],
    "accessories": [ ... ],
    "deviceHistory": [ ... ]
  }
}
```

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

## 9. Notificaciones Push (Firebase FCM)

### `POST /api/fcm/token`

Registra o actualiza el token FCM del dispositivo para recibir notificaciones push.

**Body (JSON):**

```json
{
    "token": "f7Jk2...lmno"
}
```

**Respuesta `200`:**

```json
{
    "success": true,
    "message": "Token FCM guardado correctamente"
}
```

> Llamar este endpoint después del login y cada vez que Firebase genere un nuevo token.

---

### `DELETE /api/fcm/token`

Elimina el token FCM (llamar al hacer logout para dejar de recibir notificaciones).

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

```
1. GET  /api/work-orders?tecnico_id={id}&estado=pendiente
        → Cargar órdenes asignadas al técnico

2. GET  /api/work-orders/{id}
        → Ver detalle completo de la orden

3. POST /api/work-orders/{id}/iniciar
        → Iniciar trabajo (estado: pendiente → en_proceso)

4. GET  /api/work-orders/templates/checklist
        → Cargar plantillas de inspección

5. POST /api/work-orders/{id}/checklist  (repetir por cada ítem, fase="before")
        → Registrar checklist inicial

6. POST /api/work-orders/{id}/fotos      (varias veces)
        → Subir fotos de evidencia

7. POST /api/work-orders/{id}/dispositivos
        → Registrar IMEI/SIM instalado

8. POST /api/work-orders/{id}/checklist  (repetir por cada ítem, fase="after")
        → Registrar checklist final

9. POST /api/work-orders/{id}/firmas  (tipo="conformidad")
        → Capturar firma del cliente

10. POST /api/work-orders/{id}/finalizar
         → Finalizar orden (estado: en_proceso → finalizado)
```

---

## Resumen de endpoints

| Método   | Endpoint                                | Auth | Descripción                |
| -------- | --------------------------------------- | ---- | -------------------------- |
| `POST`   | `/api/auth/login`                       | ❌   | Login con email/password   |
| `POST`   | `/api/auth/logout`                      | ✅   | Cerrar sesión              |
| `GET`    | `/api/auth/me`                          | ✅   | Perfil del técnico         |
| `GET`    | `/api/work-orders`                      | ✅   | Listar órdenes             |
| `GET`    | `/api/work-orders/{id}`                 | ✅   | Detalle de orden           |
| `POST`   | `/api/work-orders/{id}/iniciar`         | ✅   | Iniciar orden              |
| `POST`   | `/api/work-orders/{id}/finalizar`       | ✅   | Finalizar orden            |
| `POST`   | `/api/work-orders/{id}/cerrar`          | ✅   | Cerrar y bloquear          |
| `POST`   | `/api/work-orders/{id}/cancelar`        | ✅   | Cancelar orden             |
| `GET`    | `/api/work-orders/templates/checklist`  | ✅   | Plantillas de checklist    |
| `GET`    | `/api/work-orders/{id}/checklist`       | ✅   | Checklist de la orden      |
| `POST`   | `/api/work-orders/{id}/checklist`       | ✅   | Guardar ítem de checklist  |
| `GET`    | `/api/work-orders/{id}/fotos`           | ✅   | Listar fotos               |
| `POST`   | `/api/work-orders/{id}/fotos`           | ✅   | Subir foto (multipart)     |
| `DELETE` | `/api/work-orders/fotos/{id}`           | ✅   | Eliminar foto              |
| `GET`    | `/api/work-orders/fotos/{id}/download`  | ✅   | Descargar foto             |
| `GET`    | `/api/work-orders/{id}/firmas`          | ✅   | Listar firmas              |
| `POST`   | `/api/work-orders/{id}/firmas`          | ✅   | Guardar firma (base64)     |
| `GET`    | `/api/work-orders/firmas/{id}/download` | ✅   | Descargar firma PNG        |
| `GET`    | `/api/work-orders/{id}/dispositivos`    | ✅   | Historial de dispositivos  |
| `POST`   | `/api/work-orders/{id}/dispositivos`    | ✅   | Registrar IMEI/SIM         |
| `GET`    | `/api/work-orders/{id}/accesorios`      | ✅   | Listar accesorios          |
| `POST`   | `/api/work-orders/{id}/accesorios`      | ✅   | Agregar accesorio          |
| `DELETE` | `/api/work-orders/accesorios/{id}`      | ✅   | Eliminar accesorio         |
| `POST`   | `/api/fcm/token`                        | ✅   | Registrar token FCM (push) |
| `DELETE` | `/api/fcm/token`                        | ✅   | Eliminar token FCM         |
