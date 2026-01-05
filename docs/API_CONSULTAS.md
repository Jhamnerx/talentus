# API de Consultas Públicas

API REST para consultar actas, certificados GPS y certificados de velocímetro por código desde aplicaciones web externas.

## Características

-   **Públicas**: No requieren autenticación
-   **Cross-origin**: Configurar CORS según sea necesario
-   **Búsqueda por código**: Único parámetro requerido
-   **Datos completos**: Retorna información del documento, vehículo y cliente

## Endpoints Disponibles

### 1. Buscar Acta por Código

Busca un acta de instalación por su código único.

**Endpoint:** `GET /api/consultas/acta/{codigo}`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/acta/ACTA-2025-001
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "acta": {
            "id": 1,
            "codigo": "ACTA-2025-001",
            "unique_hash": "abc123def456",
            "fecha_instalacion": "2025-01-15",
            "inicio_cobertura": "2025-01-15",
            "fin_cobertura": "2026-01-15",
            "estado": true,
            "ciudad": "Lima"
        },
        "vehiculo": {
            "id": 10,
            "placa": "ABC123",
            "marca": "Toyota",
            "modelo": "Corolla",
            "year": "2023",
            "color": "Blanco"
        },
        "cliente": {
            "razon_social": "Transportes SAC"
        }
    }
}
```

**Response cuando no existe (404 Not Found):**

```json
{
    "success": false,
    "message": "Acta no encontrada"
}
```

---

### 2. Buscar Certificado GPS por Código

Busca un certificado de instalación GPS por su código único.

**Endpoint:** `GET /api/consultas/certificado-gps/{codigo}`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/certificado-gps/CERT-GPS-2025-001
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "certificado": {
            "id": 1,
            "codigo": "CERT-GPS-2025-001",
            "unique_hash": "xyz789ghi012",
            "fecha_instalacion": "2025-01-15",
            "fin_cobertura": "2026-01-15",
            "estado": true,
            "ciudad": "Lima",
            "imei": "123456789012345",
            "year": "2025"
        },
        "vehiculo": {
            "id": 10,
            "placa": "XYZ789",
            "marca": "Hyundai",
            "modelo": "Accent",
            "year": "2024",
            "color": "Negro"
        },
        "cliente": {
            "razon_social": "Logística Express SAC"
        }
    }
}
```

**Response cuando no existe (404 Not Found):**

```json
{
    "success": false,
    "message": "Certificado GPS no encontrado"
}
```

---

### 3. Buscar Certificado de Velocímetro por Código

Busca un certificado de instalación de velocímetro por su código único.

**Endpoint:** `GET /api/consultas/certificado-velocimetro/{codigo}`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/certificado-velocimetro/CERT-VEL-2025-001
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "certificado": {
            "id": 14,
            "codigo": "C-23-0014",
            "unique_hash": "XV4xYGZl5Vl6KeRBD1Oz",
            "numero": "0014",
            "fecha": "2023-05-15",
            "velocimetro_modelo": "VDO 140 KM/H",
            "year": "2023",
            "estado": true,
            "ciudad": "Cajamarca"
        },
        "vehiculo": {
            "id": 827,
            "placa": "F4K-964",
            "marca": "HYUNDAI",
            "modelo": "COUNTY",
            "year": "2020",
            "color": "BLANCO"
        },
        "cliente": {
            "razon_social": "SPTNOR S.R.L."
        }
    }
}
```

**Response cuando no existe (404 Not Found):**

```json
{
    "success": false,
    "message": "Certificado de velocímetro no encontrado"
}
```

---

## Códigos de Estado HTTP

| Código | Descripción                                             |
| ------ | ------------------------------------------------------- |
| 200    | Éxito - Documento encontrado                            |
| 404    | No encontrado - El código no existe en la base de datos |
| 500    | Error del servidor                                      |

---

## 4. Consultar Transmisión de Vehículo

Consulta si un vehículo está transmitiendo datos GPS y obtiene información del dispositivo.

**Endpoint:** `GET /api/consultas/transmision/{placa}`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/transmision/F4K-964
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "vehiculo": {
            "id": 827,
            "placa": "F4K-964",
            "marca": "HYUNDAI",
            "modelo": "COUNTY",
            "year": "2020",
            "color": "BLANCO"
        },
        "cliente": {
            "razon_social": "SPTNOR S.R.L."
        },
        "dispositivo": {
            "imei": "865456789012345",
            "nombre": "GPS-HYUNDAI-F4K964",
            "transmitiendo": true,
            "ultima_actualizacion": "2025-12-31 14:30:45"
        },
        "ultima_acta": {
            "codigo": "C-23-0014",
            "unique_hash": "XV4xYGZl5Vl6KeRBD1Oz",
            "fecha_instalacion": "2023-05-15",
            "fin_cobertura": "2024-05-15",
            "pdf_url": "https://tu-dominio.test/api/consultas/acta/C-23-0014/pdf"
        },
        "contratos": [
            {
                "id": 123,
                "unique_hash": "abc123def456",
                "numero": "CONT-2023-001",
                "fecha_inicio": "2023-01-15",
                "estado": true,
                "pdf_url": "https://tu-dominio.test/api/consultas/contrato/abc123def456/pdf"
            }
        ]
    }
}
```

**Response cuando no encuentra el vehículo (404 Not Found):**

```json
{
    "success": false,
    "message": "Vehículo no encontrado"
}
```

**Response cuando no encuentra dispositivo GPS (404 Not Found):**

```json
{
    "success": false,
    "message": "No se encontró dispositivo GPS para esta placa"
}
```

---

## 5. Obtener PDF de Acta

Obtiene el PDF de un acta en formato base64 para renderizar en el navegador.

**Endpoint:** `GET /api/consultas/acta/{codigo}/pdf`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/acta/C-23-0014/pdf
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "codigo": "C-23-0014",
        "filename": "acta_C-23-0014.pdf",
        "pdf_base64": "JVBERi0xLjQKJeLjz9MKMyAwIG9iago8P...",
        "content_type": "application/pdf"
    }
}
```

**Uso en Frontend:**

```javascript
// Obtener y mostrar PDF
fetch("https://tu-dominio.test/api/consultas/acta/C-23-0014/pdf")
    .then((response) => response.json())
    .then((data) => {
        // Crear un iframe o embed para mostrar el PDF
        const pdfData = `data:${data.data.content_type};base64,${data.data.pdf_base64}`;

        // Opción 1: Mostrar en iframe
        const iframe = document.createElement("iframe");
        iframe.src = pdfData;
        iframe.width = "100%";
        iframe.height = "600px";
        document.body.appendChild(iframe);

        // Opción 2: Descargar el archivo
        const link = document.createElement("a");
        link.href = pdfData;
        link.download = data.data.filename;
        link.click();
    });
```

---

## 6. Obtener PDF de Contrato

Obtiene el PDF de un contrato en formato base64 para renderizar en el navegador.

**Endpoint:** `GET /api/consultas/contrato/{hash}/pdf`

**Ejemplo de Request:**

```bash
GET https://tu-dominio.test/api/consultas/contrato/abc123def456/pdf
```

**Ejemplo de Response (200 OK):**

```json
{
    "success": true,
    "data": {
        "unique_hash": "abc123def456",
        "numero": "CONT-2023-001",
        "filename": "contrato_CONT-2023-001.pdf",
        "pdf_base64": "JVBERi0xLjQKJeLjz9MKMyAwIG9iago8P...",
        "content_type": "application/pdf"
    }
}
```

---

## 7. Enviar Mensaje de Contacto

Recibe mensajes de contacto desde formularios web externos.

**Endpoint:** `POST /api/contacto`

**Ejemplo de Request:**

```bash
POST https://tu-dominio.test/api/contacto
Content-Type: application/json
```

**Body (JSON):**

```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "phone": "990415525",
    "company": "Mi Empresa SAC",
    "message": "Necesito información sobre los servicios GPS",
    "g-recaptcha-response": "token_recaptcha_aqui"
}
```

**Ejemplo de Response (201 Created):**

```json
{
    "success": true,
    "message": "Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.",
    "data": {
        "id": 123,
        "created_at": "2025-12-31 12:30:45"
    }
}
```

**Response cuando hay errores de validación (422 Unprocessable Entity):**

```json
{
    "success": false,
    "message": "Error de validación",
    "errors": {
        "email": ["El correo electrónico no es válido"],
        "message": ["El mensaje es obligatorio"]
    }
}
```

**Campos Requeridos:**

-   `name` (string, max 255) - Nombre completo
-   `email` (string, email válido, max 255) - Correo electrónico
-   `message` (string, max 5000) - Mensaje
-   `g-recaptcha-response` (string) - Token de Google reCAPTCHA

**Campos Opcionales:**

-   `phone` (string, max 20) - Número de teléfono
-   `company` (string, max 255) - Nombre de la empresa

**Uso en Frontend:**

```javascript
async function enviarContacto(formData) {
    try {
        const response = await fetch("https://tu-dominio.test/api/contacto", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            body: JSON.stringify({
                name: formData.name,
                email: formData.email,
                phone: formData.phone,
                company: formData.company,
                message: formData.message,
                "g-recaptcha-response": grecaptcha.getResponse(),
            }),
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            // Limpiar formulario
        } else {
            console.error("Errores:", data.errors);
        }
    } catch (error) {
        console.error("Error:", error);
    }
}
```

---

## Códigos de Estado HTTP (Actualizado)

| Código | Descripción                                             |
| ------ | ------------------------------------------------------- |
| 200    | Éxito - Documento encontrado                            |
| 201    | Creado - Mensaje de contacto enviado exitosamente       |
| 404    | No encontrado - El código no existe en la base de datos |
| 422    | Error de validación - Datos incorrectos o incompletos   |
| 500    | Error del servidor                                      |

---

## Integración en Frontend

### JavaScript Fetch API

```javascript
async function buscarActa(codigo) {
    try {
        const response = await fetch(
            `https://tu-dominio.test/api/consultas/acta/${codigo}`
        );
        const data = await response.json();

        if (data.success) {
            console.log("Acta encontrada:", data.data);
            // Procesar datos
            const { acta, vehiculo, cliente } = data.data;
            // Mostrar en UI
        } else {
            console.error("Error:", data.message);
        }
    } catch (error) {
        console.error("Error de red:", error);
    }
}
```

### jQuery

```javascript
$.ajax({
    url: `https://tu-dominio.test/api/consultas/certificado-gps/${codigo}`,
    method: "GET",
    dataType: "json",
    success: function (response) {
        if (response.success) {
            console.log("Certificado:", response.data.certificado);
            console.log("Vehículo:", response.data.vehiculo);
            console.log("Cliente:", response.data.cliente);
        }
    },
    error: function (xhr) {
        console.error("Error:", xhr.status);
    },
});
```

### Axios

```javascript
axios
    .get(
        `https://tu-dominio.test/api/consultas/certificado-velocimetro/${codigo}`
    )
    .then((response) => {
        const { certificado, vehiculo, cliente } = response.data.data;
        // Procesar datos
    })
    .catch((error) => {
        if (error.response && error.response.status === 404) {
            console.log("Certificado no encontrado");
        }
    });
```

---

## Notas Importantes

1. **Sin autenticación**: Estas rutas son públicas, cualquiera con el código puede consultar la información
2. **CORS**: Si la consulta se realiza desde otro dominio, asegúrate de configurar CORS en `config/cors.php`
3. **Rate Limiting**: Considera implementar rate limiting para evitar abuso de las APIs
4. **Cache**: Los datos pueden ser cacheados para mejorar el rendimiento
5. **Scope Global**: La API utiliza `withoutGlobalScope(EmpresaScope::class)` para permitir búsquedas entre todas las empresas
6. **Privacidad de Datos**: El endpoint de transmisión **NO** devuelve datos sensibles como coordenadas GPS, velocidad, dirección o estado del motor. Solo proporciona información básica del dispositivo y su estado de transmisión

---

## Testing

Los tests están ubicados en `tests/Feature/Api/ConsultasApiTest.php`

Ejecutar tests:

```bash
php artisan test --filter ConsultasApiTest
```

---

## Seguridad

### Recomendaciones

1. **Validación de códigos**: Los códigos deben ser únicos y difíciles de adivinar
2. **Throttling**: Implementar limitación de peticiones por IP
3. **Monitoreo**: Registrar accesos sospechosos o intentos masivos de consulta
4. **HTTPS**: Usar HTTPS en producción para encriptar la comunicación

### Ejemplo de Rate Limiting (opcional)

Agregar en `routes/api.php`:

```php
Route::middleware('throttle:60,1')->prefix('consultas')->group(function () {
    // Rutas de consulta aquí...
});
```

Esto limita a 60 peticiones por minuto por IP.

---

## Soporte

Para dudas o problemas, contactar al equipo de desarrollo de Talentus.
