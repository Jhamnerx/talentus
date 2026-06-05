---
name: talentus-mobile-api
description: "API contract and business rules for the Talentus mobile app for field technicians. Activate when building, designing or debugging the mobile app that consumes the Talentus REST API. Covers auth, work order lifecycle, checklist, photos, signatures, GPS tracking, FCM push, and all endpoints."
license: MIT
metadata:
  author: talentus
---

# Talentus Mobile API — Skill para Desarrollo de App Técnicos

## Cuándo usar este skill

Activar siempre que trabajes en la **app móvil de técnicos de campo** de Talentus:
- Integrar cualquier endpoint del API
- Diseñar pantallas/flujos que consumen datos de la API
- Manejar autenticación Sanctum
- Implementar tracking GPS, firmas digitales, upload de fotos
- Depurar errores de integración

La documentación completa está en: `docs/API_MOBILE_TECNICOS.md`

---

## Datos de conexión

```
Base URL:      https://{dominio}/api
Auth:          Bearer Token (Laravel Sanctum)
Content-Type:  application/json
Accept:        application/json
Zona horaria:  America/Lima
```

Cabeceras requeridas en toda petición autenticada:
```http
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

Para upload de fotos usar `multipart/form-data` (NO `application/json`).

---

## Autenticación

### Login
```
POST /api/auth/login
Body: { email, password, device_name? }
```
- Solo usuarios con rol `tecnico` pueden autenticarse
- Devuelve `token` (Bearer) + `user` object
- El token no expira; guardarlo en almacenamiento seguro (Keychain / EncryptedSharedPreferences)
- Al recibir `401` en cualquier endpoint: redirigir a login

### Logout
```
POST /api/auth/logout   → revoca el token actual
DELETE /api/fcm/token   → llamar ANTES del logout para dejar de recibir push
```

### Perfil
```
GET /api/auth/me  → { id, name, email, telefono, ciudad, roles, permisos }
```

### FCM Push
```
POST /api/fcm/token   Body: { token }   → registrar después del login
DELETE /api/fcm/token                   → borrar antes del logout
```

---

## Estados de una Orden y transiciones válidas

```
PENDIENTE ──► EN_PROCESO ──► FINALIZADO ──► bloqueado=true (cerrado)
                │
                └──► CANCELADO (bloqueado=true)
```

| Campo       | Valor           | Significado                                         |
|-------------|-----------------|-----------------------------------------------------|
| `estado`    | `pendiente`     | Asignada, sin iniciar                               |
| `estado`    | `en_proceso`    | Técnico trabajando                                  |
| `estado`    | `finalizado`    | Trabajo terminado con firma conformidad             |
| `estado`    | `cancelado`     | Cancelada con motivo                                |
| `bloqueado` | `true`          | Inmutable — cerrada o cancelada, no se puede editar |

**Regla clave:** `puedeEditar = !bloqueado && estado IN (pendiente, en_proceso)`

---

## Endpoints — Referencia rápida

### Dashboard
```
GET /api/work-orders/stats
→ { pendientes, en_proceso, total_activas, finalizadas_hoy, finalizadas_mes }
```

### Listado y detalle
```
GET /api/work-orders
  ?estado=pendiente|en_proceso|finalizado|cancelado
  &fecha_desde=YYYY-MM-DD
  &fecha_hasta=YYYY-MM-DD
  &search=OT00042|ABC-123|texto
  &per_page=15 (min:5, max:100)
  → Auto-filtra por técnico autenticado (NO pasar tecnico_id desde la app)

GET /api/work-orders/{id}
  → Detalle completo con: tipo, vehiculo, cliente, tecnico, checklists,
    photos, signatures, accessories, deviceHistory
  → Si es_proyecto=true: incluye items[], vehiculo=null, cliente=null

PATCH /api/work-orders/{id}
  Body: { imei_gps?, imei_sim?, observaciones?, contacto?, sector? }
  → Solo cuando puedeEditar=true
```

### Ciclo de vida
```
POST /api/work-orders/{id}/iniciar
  → pendiente → en_proceso, registra fecha_inicio

POST /api/work-orders/{id}/finalizar
  Body: { observaciones_final? }
  → REQUIERE firma conformidad previa
  → en_proceso → finalizado, registra fecha_finalizacion

POST /api/work-orders/{id}/cerrar
  → finalizado → bloqueado=true (solo desde admin web)

POST /api/work-orders/{id}/cancelar
  Body: { motivo_cancelacion }  ← REQUERIDO
  → cualquier estado (no bloqueado) → cancelado
```

### Checklist
```
GET  /api/work-orders/templates/checklist
  → { "CARROCERÍA": [{id, nombre, descripcion}], "MOTOR": [...] }

GET  /api/work-orders/{id}/checklist
  → { before: [...], after: [...] }

POST /api/work-orders/{id}/checklist
  Body: { checklist_template_id, fase, resultado, observaciones? }
  fase:      before | after
  resultado: ok | observado | no_aplica
  → updateOrCreate: si el mismo template+fase ya existe, lo actualiza
```

### Fotos
```
GET  /api/work-orders/{id}/fotos

POST /api/work-orders/{id}/fotos   ← multipart/form-data
  foto:                    file image (max 5MB)
  tipo:                    checklist | general | evidencia
  fase?:                   before | after | proceso
  work_order_checklist_id?: integer
  descripcion?:            string
  latitude?:               number
  longitude?:              number

DELETE /api/work-orders/fotos/{photo_id}
GET    /api/work-orders/fotos/{photo_id}/download
```

### Firmas digitales
```
GET  /api/work-orders/{id}/firmas

POST /api/work-orders/{id}/firmas
  Body:
  {
    tipo:               recepcion | conformidad
    firma_base64:       "data:image/png;base64,..."  ← canvas PNG en base64
    nombre_firmante:    string
    tipo_firmante:      conductor | cliente | encargado | supervisor
    documento_firmante?: string (DNI/RUC)
    latitude?:          number
    longitude?:         number
  }
  → Solo UNA firma por tipo por orden; duplicado devuelve 422
  → conformidad es REQUERIDA antes de llamar /finalizar

GET /api/work-orders/firmas/{signature_id}/download
```

### Dispositivos GPS / SIM (orden individual)
```
GET  /api/work-orders/{id}/dispositivos   → historial append-only

POST /api/work-orders/{id}/dispositivos
  Body:
  {
    dispositivo_id?:        integer
    imei?:                  string (max 20)
    accion_imei:            instalado | retirado | reemplazado | ninguna
    sim_card_id?:           integer
    iccid?:                 string
    numero_linea?:          string
    accion_sim:             instalado | retirado | reemplazado | ninguna
    dispositivo_anterior_id?: integer
    sim_card_anterior_id?:  integer
    observaciones?:         string
  }
  → Usar "ninguna" cuando no se hace nada con ese componente
```

### Accesorios
```
GET    /api/work-orders/{id}/accesorios
  → { items: [...], total: 45.00 }

POST   /api/work-orders/{id}/accesorios
  Body: { producto_id?, nombre, descripcion?, cantidad, serial?, accion, precio_unitario }
  accion: instalado | retirado | reemplazado
  → subtotal se calcula automáticamente (cantidad × precio_unitario)

DELETE /api/work-orders/accesorios/{accessory_id}
```

### Tracking GPS del técnico
```
POST /api/work-orders/{id}/tracking   ← cada ~60 segundos durante el trabajo
  Body: { lat, lng, accuracy?, speed? }
  → Solo el técnico ASIGNADO puede enviar; otros reciben 403
  → updateQuietly: no dispara eventos ni activity log
```

### Ítems del proyecto (solo es_proyecto=true)
```
GET   /api/work-orders/{id}/items
  → { items, total, completados, omitidos, pendientes, progreso(%) }

POST  /api/work-orders/{id}/items
  Body: { placa, work_order_type_id, notas? }

PATCH /api/work-orders/{id}/items/{item_id}/estado
  → Ciclo: pendiente → completado → omitido → pendiente (no body)

PATCH /api/work-orders/{id}/items/{item_id}/dispositivo
  Body: { imei?, numero_sim? }

DELETE /api/work-orders/{id}/items/{item_id}
```

---

## Flujo completo — Orden individual

```
App start:
  1. POST /api/auth/login          → guardar token + user.id
  2. POST /api/fcm/token           → registrar token push
  3. GET  /api/work-orders/stats   → mostrar dashboard

Ver lista de trabajo:
  4. GET  /api/work-orders?estado=pendiente   → cards con ordenes

Atender una orden:
  5.  GET  /api/work-orders/{id}          → cargar detalle completo
  6.  POST /api/work-orders/{id}/iniciar  → cambiar a en_proceso

  [En paralelo, enviar tracking cada 60s]
  →  POST /api/work-orders/{id}/tracking  → { lat, lng }

  7.  GET  /api/work-orders/templates/checklist    → cargar plantillas (cachear)
  8.  POST /api/work-orders/{id}/checklist × N     → fase=before, por cada ítem
  9.  POST /api/work-orders/{id}/fotos × N         → fotos antes y durante
  10. POST /api/work-orders/{id}/dispositivos      → registrar GPS/SIM instalado
  11. POST /api/work-orders/{id}/accesorios × N    → accesorios (opcional)
  12. POST /api/work-orders/{id}/checklist × N     → fase=after
  13. POST /api/work-orders/{id}/firmas            → tipo=conformidad (lienzo)
  14. POST /api/work-orders/{id}/finalizar         → { observaciones_final? }
```

## Flujo completo — Orden tipo proyecto

```
  1-4. Igual que orden individual

  5. GET  /api/work-orders/{id}          → es_proyecto=true, items=[...]
  6. POST /api/work-orders/{id}/iniciar

  Por cada vehículo en items[]:
  7. POST /api/work-orders/{id}/fotos                     → foto del vehículo
  8. PATCH /api/work-orders/{id}/items/{item}/dispositivo → imei + numero_sim
  9. PATCH /api/work-orders/{id}/items/{item}/estado      → completado (o omitido)

  10. POST /api/work-orders/{id}/firmas   → tipo=conformidad
  11. POST /api/work-orders/{id}/finalizar
```

---

## Manejo de errores

```json
{ "success": false, "message": "Descripción del error" }
```

| Código | Acción en la app                                          |
|--------|-----------------------------------------------------------|
| `401`  | Token inválido → limpiar storage → redirigir a login      |
| `403`  | Sin permiso → mostrar mensaje → NO redirigir a login      |
| `404`  | Recurso no existe → mostrar error descriptivo             |
| `422`  | Validación o regla de negocio → mostrar mensaje.message   |
| `500`  | Error servidor → mostrar "Error interno, intente de nuevo"|

---

## Reglas de negocio que el app DEBE respetar

1. **No mostrar botón "Iniciar"** si `estado !== 'pendiente'`
2. **No mostrar botón "Finalizar"** si `estado !== 'en_proceso'`
3. **No permitir editar** si `bloqueado === true`
4. **Verificar** si existe firma `conformidad` antes de mostrar botón "Finalizar" (GET /firmas)
5. **Para proyectos:** mostrar progreso `progreso%` y estado de cada ítem
6. **Tracking GPS:** iniciar envío periódico al `iniciar()`, detener al `finalizar()`
7. **FCM token:** registrar al login, borrar al logout
8. **Fotos privadas:** descargar siempre via `/download` — las rutas de storage son privadas
9. **Una sola firma por tipo:** verificar que no exista antes de mostrar el lienzo de firma

---

## Estructura de datos clave

### WorkOrder (objeto raíz)
```json
{
  "id": 42,
  "codigo": "OT00042",
  "es_proyecto": false,
  "estado": "en_proceso",
  "bloqueado": false,
  "fecha_programada": "2026-06-05T08:00:00",
  "fecha_inicio": "2026-06-05T08:15:00",
  "fecha_finalizacion": null,
  "observaciones": "Instalar en tablero central",
  "observaciones_final": null,
  "sector": "SUTRAN",
  "contacto": "Carlos Ríos — 999000111",
  "imei_gps": null,
  "imei_sim": null,
  "tipo": { "id": 1, "nombre": "Instalación GPS" },
  "vehiculo": { "id": 10, "placa": "ABC-123", "marca": "TOYOTA", "modelo": "HILUX" },
  "cliente": { "id": 3, "razon_social": "Empresa SAC", "numero_documento": "20123456789" },
  "tecnico": { "id": 5, "name": "Juan Pérez" },
  "checklists": [],
  "photos": [],
  "signatures": [],
  "accessories": [],
  "deviceHistory": []
}
```

### WorkOrderItem (solo proyectos)
```json
{
  "id": 101,
  "placa": "ABC-123",
  "estado": "pendiente",
  "imei": null,
  "numero_sim": null,
  "notas": "Cambio de chip urgente",
  "orden": 0,
  "cliente_nombre": "Empresa SAC",
  "tipo": { "id": 2, "nombre": "Mantenimiento" },
  "vehiculo": { "id": 10, "placa": "ABC-123", "marca": "VOLVO" }
}
```

### WorkOrderSignature
```json
{
  "id": 7,
  "tipo": "conformidad",
  "nombre_firmante": "Carlos Ríos",
  "tipo_firmante": "conductor",
  "documento_firmante": "12345678",
  "firmado_at": "2026-06-05T10:30:00",
  "latitude": -12.046374,
  "longitude": -77.042793,
  "hash": "sha256_del_archivo_png"
}
```
