# Work Orders API - Documentación

## Autenticación

Todas las rutas API requieren autenticación con **Laravel Sanctum**.

### Obtener Token de Acceso

```http
POST /api/login
Content-Type: application/json

{
  "email": "tecnico@example.com",
  "password": "password123"
}
```

**Respuesta:**

```json
{
    "token": "1|abc123xyz...",
    "user": {
        "id": 1,
        "name": "Juan Pérez",
        "email": "tecnico@example.com"
    }
}
```

### Usar Token en Peticiones

Incluir el token en el header `Authorization`:

```http
Authorization: Bearer 1|abc123xyz...
Accept: application/json
```

---

## Endpoints API

Base URL: `https://talentus.test/api`

### 1. Listar Órdenes de Trabajo

```http
GET /api/work-orders
Authorization: Bearer {token}
Accept: application/json
```

**Query Parameters:**

-   `estado` - Filtrar por estado: `pendiente`, `en_proceso`, `finalizado`, `cancelado`
-   `tecnico_id` - Filtrar por técnico asignado
-   `search` - Buscar por código o placa
-   `per_page` - Registros por página (default: 15)

**Respuesta:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "codigo": "OT25-000001",
                "uuid": "550e8400-e29b-41d4-a716-446655440000",
                "estado": "en_proceso",
                "fecha_programada": "2025-12-22 14:00:00",
                "bloqueado": false,
                "tipo": {
                    "id": 1,
                    "nombre": "Instalación GPS"
                },
                "vehiculo": {
                    "id": 10,
                    "placa": "ABC-123"
                },
                "cliente": {
                    "id": 5,
                    "nombres": "Empresa XYZ SAC"
                },
                "tecnico": {
                    "id": 3,
                    "name": "Juan Pérez"
                }
            }
        ],
        "per_page": 15,
        "total": 50
    }
}
```

---

### 2. Ver Detalle de Orden

```http
GET /api/work-orders/{workOrder}
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "codigo": "OT25-000001",
    "estado": "en_proceso",
    "tipo_data": {
      "nombre": "Instalación GPS",
      "costo_base": 150.00,
      "requiere_imei": true,
      "requiere_sim": true
    },
    "fecha_inicio": "2025-12-22 09:00:00",
    "checklists": [...],
    "photos": [...],
    "signatures": [...],
    "deviceHistory": [...]
  }
}
```

---

### 3. Iniciar Orden de Trabajo

```http
POST /api/work-orders/{workOrder}/iniciar
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
    "success": true,
    "message": "Orden de trabajo iniciada correctamente",
    "data": {
        "id": 1,
        "estado": "en_proceso",
        "fecha_inicio": "2025-12-22 09:00:00"
    }
}
```

---

### 4. Finalizar Orden

```http
POST /api/work-orders/{workOrder}/finalizar
Authorization: Bearer {token}
Content-Type: application/json

{
  "observaciones_final": "Trabajo completado sin novedades"
}
```

**Respuesta:**

```json
{
    "success": true,
    "message": "Orden de trabajo finalizada correctamente",
    "data": {
        "id": 1,
        "estado": "finalizado",
        "fecha_finalizacion": "2025-12-22 17:30:00"
    }
}
```

---

### 5. Cancelar Orden

```http
POST /api/work-orders/{workOrder}/cancelar
Authorization: Bearer {token}
Content-Type: application/json

{
  "motivo_cancelacion": "Cliente canceló el servicio"
}
```

**Validaciones:**

-   `motivo_cancelacion` - **Requerido**, string, max 500 caracteres

---

### 6. Listar Templates de Checklist

```http
GET /api/work-orders/templates/checklist
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
  "success": true,
  "data": {
    "vehiculo": [
      {
        "id": 1,
        "nombre": "Estado de carrocería",
        "categoria": "vehiculo",
        "requiere_foto": true,
        "orden": 1
      }
    ],
    "tablero": [...],
    "luces": [...]
  }
}
```

---

### 7. Listar Checklist de Orden

```http
GET /api/work-orders/{workOrder}/checklist
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
  "success": true,
  "data": {
    "before": [
      {
        "id": 1,
        "resultado": "ok",
        "observaciones": null,
        "inspeccionado_at": "2025-12-22 09:15:00",
        "template": {
          "nombre": "Estado de carrocería"
        }
      }
    ],
    "after": [...]
  }
}
```

---

### 8. Guardar Checklist

```http
POST /api/work-orders/{workOrder}/checklist
Authorization: Bearer {token}
Content-Type: application/json

{
  "checklist_template_id": 1,
  "fase": "before",
  "resultado": "ok",
  "observaciones": "Sin daños visibles"
}
```

**Validaciones:**

-   `checklist_template_id` - **Requerido**, existe en DB
-   `fase` - **Requerido**, valores: `before`, `after`
-   `resultado` - **Requerido**, valores: `ok`, `observado`, `no_aplica`
-   `observaciones` - Opcional, string

**Respuesta:**

```json
{
  "success": true,
  "message": "Checklist guardado correctamente",
  "data": {
    "id": 1,
    "resultado": "ok",
    "fase": "before",
    "template": {...}
  }
}
```

---

### 9. Listar Fotos

```http
GET /api/work-orders/{workOrder}/fotos
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "filename": "foto_1234567890.jpg",
            "tipo": "evidencia",
            "fase": "before",
            "descripcion": "Foto frontal del vehículo",
            "latitude": -12.046374,
            "longitude": -77.042793,
            "url": "https://api.talentus.test/api/work-orders/fotos/1/download",
            "uploaded_by": {
                "id": 3,
                "name": "Juan Pérez"
            }
        }
    ]
}
```

---

### 10. Subir Foto

```http
POST /api/work-orders/{workOrder}/fotos
Authorization: Bearer {token}
Content-Type: multipart/form-data

foto: [archivo]
tipo: evidencia
fase: before
descripcion: Foto frontal del vehículo
latitude: -12.046374
longitude: -77.042793
```

**Validaciones:**

-   `foto` - **Requerido**, imagen, max 5MB
-   `tipo` - **Requerido**, valores: `checklist`, `general`, `evidencia`
-   `fase` - Opcional, valores: `before`, `after`, `proceso`
-   `descripcion` - Opcional, string, max 500
-   `latitude`, `longitude` - Opcional, numeric

**Respuesta:**

```json
{
    "success": true,
    "message": "Foto subida correctamente",
    "data": {
        "id": 1,
        "filename": "foto_1234567890.jpg",
        "path": "work-orders/1/photos/foto_1234567890.jpg",
        "url": "https://api.talentus.test/api/work-orders/fotos/1/download"
    }
}
```

---

### 11. Eliminar Foto

```http
DELETE /api/work-orders/fotos/{photo}
Authorization: Bearer {token}
Accept: application/json
```

---

### 12. Descargar Foto

```http
GET /api/work-orders/fotos/{photo}/download
Authorization: Bearer {token}
```

Retorna el archivo binario de la imagen.

---

### 13. Listar Firmas

```http
GET /api/work-orders/{workOrder}/firmas
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "tipo": "recepcion",
            "nombre_firmante": "Carlos López",
            "documento_firmante": "12345678",
            "tipo_firmante": "conductor",
            "firmado_at": "2025-12-22 09:00:00",
            "hash": "abc123def456...",
            "tecnico": {
                "id": 3,
                "name": "Juan Pérez"
            }
        }
    ]
}
```

---

### 14. Guardar Firma

```http
POST /api/work-orders/{workOrder}/firmas
Authorization: Bearer {token}
Content-Type: application/json

{
  "tipo": "recepcion",
  "firma_base64": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUg...",
  "nombre_firmante": "Carlos López",
  "tipo_firmante": "conductor",
  "documento_firmante": "12345678",
  "latitude": -12.046374,
  "longitude": -77.042793
}
```

**Validaciones:**

-   `tipo` - **Requerido**, valores: `recepcion`, `conformidad`
-   `firma_base64` - **Requerido**, string base64 de imagen
-   `nombre_firmante` - **Requerido**, string, max 255
-   `tipo_firmante` - **Requerido**, string, max 100
-   `documento_firmante` - Opcional, string, max 20
-   `latitude`, `longitude` - Opcional, numeric

**Respuesta:**

```json
{
    "success": true,
    "message": "Firma guardada correctamente",
    "data": {
        "id": 1,
        "tipo": "recepcion",
        "hash": "abc123def456...",
        "nombre_firmante": "Carlos López"
    }
}
```

---

### 15. Listar Dispositivos

```http
GET /api/work-orders/{workOrder}/dispositivos
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "imei": "123456789012345",
            "accion_imei": "instalado",
            "numero_linea": "987654321",
            "accion_sim": "instalado",
            "fecha_instalacion": "2025-12-22 10:00:00",
            "dispositivo": {
                "id": 5,
                "modelo": "GT06N"
            },
            "simCard": {
                "id": 10,
                "iccid": "89510000000000000001"
            }
        }
    ]
}
```

---

### 16. Guardar Dispositivo

```http
POST /api/work-orders/{workOrder}/dispositivos
Authorization: Bearer {token}
Content-Type: application/json

{
  "dispositivo_id": 5,
  "imei": "123456789012345",
  "accion_imei": "instalado",
  "sim_card_id": 10,
  "iccid": "89510000000000000001",
  "numero_linea": "987654321",
  "accion_sim": "instalado",
  "observaciones": "Instalación sin problemas"
}
```

**Validaciones:**

-   `accion_imei` - **Requerido**, valores: `instalado`, `retirado`, `reemplazado`, `ninguna`
-   `accion_sim` - **Requerido**, valores: `instalado`, `retirado`, `reemplazado`, `ninguna`

---

### 17. Listar Accesorios

```http
GET /api/work-orders/{workOrder}/accesorios
Authorization: Bearer {token}
Accept: application/json
```

**Respuesta:**

```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 1,
                "nombre": "Botón de pánico",
                "cantidad": 1,
                "precio_unitario": 45.0,
                "subtotal": 45.0,
                "accion": "instalado"
            }
        ],
        "total": 45.0
    }
}
```

---

### 18. Guardar Accesorio

```http
POST /api/work-orders/{workOrder}/accesorios
Authorization: Bearer {token}
Content-Type: application/json

{
  "producto_id": 15,
  "nombre": "Botón de pánico",
  "descripcion": "Botón de emergencia inalámbrico",
  "cantidad": 1,
  "serial": "BTN-12345",
  "accion": "instalado",
  "precio_unitario": 45.00
}
```

**Validaciones:**

-   `nombre` - **Requerido**, string, max 255
-   `cantidad` - **Requerido**, integer, min 1
-   `accion` - **Requerido**, valores: `instalado`, `retirado`, `reemplazado`
-   `precio_unitario` - **Requerido**, numeric, min 0

---

### 19. Eliminar Accesorio

```http
DELETE /api/work-orders/accesorios/{accessory}
Authorization: Bearer {token}
Accept: application/json
```

---

## Códigos de Error

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### 422 Unprocessable Entity

```json
{
    "success": false,
    "message": "No se puede editar una orden bloqueada o finalizada"
}
```

### 500 Internal Server Error

```json
{
    "success": false,
    "message": "Error al guardar: [detalle del error]"
}
```

---

## Ejemplo de Flujo Completo (App Móvil)

```javascript
// 1. Login
const loginResponse = await fetch("https://api.talentus.test/api/login", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email: "tecnico@example.com", password: "12345" }),
});
const { token } = await loginResponse.json();

// 2. Listar órdenes del técnico
const ordenesResponse = await fetch(
    "https://api.talentus.test/api/work-orders?estado=pendiente",
    {
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
        },
    }
);
const ordenes = await ordenesResponse.json();

// 3. Iniciar orden
await fetch(`https://api.talentus.test/api/work-orders/1/iniciar`, {
    method: "POST",
    headers: {
        Authorization: `Bearer ${token}`,
        Accept: "application/json",
    },
});

// 4. Obtener templates de checklist
const templatesResponse = await fetch(
    "https://api.talentus.test/api/work-orders/templates/checklist",
    {
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: "application/json",
        },
    }
);
const templates = await templatesResponse.json();

// 5. Guardar checklist BEFORE
await fetch("https://api.talentus.test/api/work-orders/1/checklist", {
    method: "POST",
    headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
    },
    body: JSON.stringify({
        checklist_template_id: 1,
        fase: "before",
        resultado: "ok",
    }),
});

// 6. Subir foto
const formData = new FormData();
formData.append("foto", fotoBlob);
formData.append("tipo", "evidencia");
formData.append("fase", "before");
formData.append("latitude", position.coords.latitude);
formData.append("longitude", position.coords.longitude);

await fetch("https://api.talentus.test/api/work-orders/1/fotos", {
    method: "POST",
    headers: { Authorization: `Bearer ${token}` },
    body: formData,
});

// 7. Guardar firma de conformidad
await fetch("https://api.talentus.test/api/work-orders/1/firmas", {
    method: "POST",
    headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
    },
    body: JSON.stringify({
        tipo: "conformidad",
        firma_base64: signatureCanvas.toDataURL(),
        nombre_firmante: "Carlos López",
        tipo_firmante: "conductor",
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
    }),
});

// 8. Finalizar orden
await fetch("https://api.talentus.test/api/work-orders/1/finalizar", {
    method: "POST",
    headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
    },
    body: JSON.stringify({
        observaciones_final: "Trabajo completado exitosamente",
    }),
});
```

---

## Notas de Implementación

1. **Autenticación Sanctum**: Configurar tokens SPA o tokens API según el tipo de cliente
2. **CORS**: Habilitar CORS en `config/cors.php` para apps móviles
3. **Rate Limiting**: Aplicar límites de peticiones para prevenir abuso
4. **Compresión**: Las fotos deben comprimirse antes de enviar (recomendado: max 1MB)
5. **Offline Mode**: Implementar cola local para trabajar sin conexión
6. **WebSockets**: Considerar Laravel Echo para notificaciones en tiempo real

---

**Versión**: 1.0  
**Última actualización**: 22/12/2025
