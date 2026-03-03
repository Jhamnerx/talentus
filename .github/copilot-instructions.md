# GitHub Copilot Instructions — Talentus

## Descripción del proyecto
**Talentus** es un sistema de gestión empresarial (ERP) orientado a empresas de GPS/rastreo vehicular en Perú. Incluye módulos de facturación electrónica (SUNAT), CRM, flota vehicular, órdenes de trabajo, soporte técnico, finanzas y más.

---

## Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | PHP 8.3 · Laravel 12 |
| Base de datos | MySQL |
| Frontend | TALL Stack: Tailwind CSS 4 · Alpine.js · Livewire 3 |
| UI Components | WireUI (wireui/wireui) |
| Data tables | PowerGrid 6 (power-components/livewire-powergrid) |
| Auth | Laravel Jetstream 5 + Fortify + Sanctum |
| Permisos | Spatie Laravel Permission 6 |
| Auditoría | Spatie Laravel Activity Log 4 |
| Real-time | Pusher + Laravel Echo |
| PDF | DomPDF (barryvdh/laravel-dompdf) |
| Excel | Maatwebsite/Excel 3 |
| Facturación | Greenter (dev-master) — SUNAT Perú |
| Firebase | kreait/laravel-firebase 6 |
| WhatsApp | netflie/whatsapp-cloud-api 2 |
| Backup | Spatie Laravel Backup 9 |
| Monitoreo | Laravel Telescope 5 |
| Suscripciones | laravelcm/laravel-subscriptions 1 |
| Hashids | vinkla/hashids |
| Enums | bensampo/laravel-enum 6 |

---

## Estructura de directorios

```
app/
  Actions/          # Acciones de Jetstream/Fortify
  Enums/            # Enums tipados con bensampo/laravel-enum
  Exports/          # Clases de exportación Excel
  Helpers/          # Helpers globales
  Http/
    Controllers/
      Admin/        # Controladores del panel de administración
        Almacen/    # Gestión de almacén y guías de remisión
        Facturacion/# Comprobantes electrónicos SUNAT
        Finanzas/   # Módulo financiero
        PDF/        # Controladores de generación PDF
      Api/          # Endpoints de API
  Imports/          # Clases de importación Excel
  Jobs/             # Jobs para colas
  Livewire/
    Admin/          # Componentes Livewire del panel
      Ajustes/      # Configuración de empresa/sistema
      Categorias/
      Certificados/ # Certificados GPS/velocímetro/antifatiga
      Clientes/
      Cobros/
      Compras/
      Dispositivos/ # Gestión de dispositivos GPS
      Facturacion/  # Emisión de comprobantes SUNAT
      Finanzas/     # Caja, pagos, egresos
      Gerencia/     # Reportes gerenciales
      GuiasRemision/
      Lineas/       # Líneas de teléfono / SIM
      Notificaciones/
      PaymentMethods/
      Payments/
      Planes/       # Planes de suscripción
      Productos/
      Proveedores/
      Reportes/
      Reviews/
      SimCard/
      Solicitudes/
      Tecnico/      # Servicio técnico
      Tickets/      # Sistema de tickets
      Usuarios/
      Vehiculos/
      Ventas/
      WorkOrders/
  Models/           # Modelos Eloquent
  Observers/        # Observers de modelos
  Policies/         # Políticas de autorización
  Rules/            # Reglas de validación personalizadas
  Scopes/           # Query scopes globales
  Services/         # Servicios de integración externa
    FactilizaService.php   # API de facturación Factiliza
    GpsWoxService.php      # API de GPS Wox
  Traits/           # Traits reutilizables
resources/
  views/
    admin/          # Vistas del panel (Blade)
    livewire/       # Vistas de componentes Livewire
    pdf/            # Plantillas PDF (DomPDF)
    components/     # Componentes Blade
routes/
  web.php           # Rutas web (protegidas por auth:sanctum + verified)
  api.php           # Rutas API
  facturacion.php   # Rutas del módulo de facturación
```

---

## Módulos principales

### 1. GPS & Flota
- Modelos: `Vehiculos`, `Dispositivos`, `Gps`, `SimCard`, `Flotas`, `DeviceHistory`
- Livewire: `Admin/Vehiculos/`, `Admin/Dispositivos/`, `Admin/SimCard/`, `Admin/Lineas/`
- Integración externa: `GpsWoxService` (jhamnerx/gpswox-api)

### 2. Facturación Electrónica (SUNAT — Perú)
- Modelos: `Comprobantes`, `Ventas`, `VentasDetalle`, `NotaCredito`, `NotaDebito`, `EnvioResumen`, `Series`, `TipoComprobantes`, `TipoAfectacion`, `CodigosDetracciones`
- Livewire: `Admin/Facturacion/`, `Admin/Ventas/`, `Admin/GuiasRemision/`
- Biblioteca: **Greenter** para firma XML y comunicación con SUNAT
- Servicio de envío: `FactilizaService`

### 3. CRM
- Modelos: `Clientes`, `Contacto`, `Contactos`, `Proveedores`
- Livewire: `Admin/Clientes/`, `Admin/Proveedores/`

### 4. Compras
- Modelos: `Compras`, `ComprasDetalle`
- Livewire: `Admin/Compras/`

### 5. Finanzas / Caja
- Modelos: `Cash`, `CashDocument`, `CashDocumentCredit`, `CashDocumentPayment`, `Cobros`, `DetalleCobros`, `Payments`, `ExpensePayment`, `ExpenseMethodType`, `PaymentMethodType`, `Anticipos`
- Livewire: `Admin/Finanzas/`, `Admin/Cobros/`, `Admin/Payments/`, `Admin/PaymentMethods/`
- Traits: `CashHelperTrait`, `FinanceTrait`

### 6. Órdenes de Trabajo (Work Orders)
- Modelos: `WorkOrder`, `WorkOrderType`, `WorkOrderChecklist`, `WorkOrderPhoto`, `WorkOrderSignature`, `WorkOrderAccessory`
- Livewire: `Admin/WorkOrders/`

### 7. Tickets / Soporte
- Modelos: `Ticket`, `TicketMessage`, `TicketAttachment`, `TicketCategory`, `TicketEvent`, `TicketSequence`
- Livewire: `Admin/Tickets/`

### 8. Servicio Técnico
- Modelos: `ServicioTecnico`, `Mantenimiento`
- Livewire: `Admin/Tecnico/`

### 9. Certificados
- Modelos: `Certificados`, `CertificadosAntifatiga`, `CertificadosVelocimetros`
- Livewire: `Admin/Certificados/`

### 10. Contratos & Presupuestos
- Modelos: `Contratos`, `DetalleContratos`, `Cotizaciones`, `CotizacionesDetalle`, `Presupuestos`, `DetallePresupuestos`

### 11. Suscripciones & Planes
- Modelos: `Plan`, `Subscription`
- Livewire: `Admin/Planes/`

### 12. Configuración de Empresa
- Modelos: `Empresa`, `Ajustes`
- Livewire: `Admin/Ajustes/`

---

## Convenciones de código

### General
- Idioma de código: **español** para nombres de clases de negocio, métodos, variables y rutas. Comentarios en español.
- Seguir PSR-12 para formato PHP.
- Usar `strict_types=1` en clases nuevas.

### Modelos
- Usar `$guarded = ['id', 'created_at', 'updated_at']` en la mayoría de modelos (ver `Ventas`, `Team`). Solo usar `$fillable` cuando se documente explícitamente.
- Definir siempre `$casts` para booleanos, fechas y enums.
- Usar **Hashids** para exponer IDs en URLs (nunca IDs numéricos directos).
- Usar `SoftDeletes` en modelos que requieran papelera de reciclaje.
- Registrar observers via el atributo PHP `#[ObservedBy(MiObserver::class)]` en la clase del modelo (patrón real del proyecto):
  ```php
  #[ObservedBy(VentasObserver::class)]
  class Ventas extends Model { ... }
  ```
- Los observers auto-asignan `empresa_id` y `user_id` en el evento `creating` — no repetir esta lógica en controllers/Livewire.

### Multi-tenancy (EmpresaScope)
Todo modelo con datos por empresa aplica `EmpresaScope` en `booted()` — filtra automáticamente por `session('empresa')`:
```php
protected static function booted(): void
{
    static::addGlobalScope(new EmpresaScope);
}
```
Usar `->withoutGlobalScope(EmpresaScope::class)` cuando se necesiten consultas cruzadas entre empresas.

### Livewire 3
- Usar `#[Lazy]` para carga diferida de componentes pesados.
- Usar `#[Validate]` o `$rules` para validación en tiempo real.
- Preferir eventos de Livewire (`$dispatch`) sobre redirecciones cuando sea posible.
- Usar **WireUI** para formularios, modales, notificaciones y selectores.
- Usar **PowerGrid** para tablas con búsqueda, filtros y paginación. Convención: clase `Tabla` dentro de la carpeta del feature (ej. `app/Livewire/Admin/Productos/Tabla.php`) extendiendo `PowerGridComponent` con `datasource()`, `fields()` y `columns()`.
- Los listeners de Echo siguen el patrón: `'echo:{canal},{Evento}' => 'metodo'`.

### Controladores
- Controladores delgados: lógica de negocio en modelos, acciones o servicios.
- Solo existir si hay lógica de renderizado de vistas o descargas (PDF, Excel).
- Primarios bajo `App\Http\Controllers\Admin\`.

### Autorización
- Usar **Spatie Permission** (roles y permisos).
- Verificar con `$this->authorize()` en controladores o `Gate::allows()` en Livewire.
- Definir políticas en `app/Policies/`.

### Rutas
- Todas las rutas del panel bajo middleware `['auth:sanctum', 'verified']`.
- Nombrar rutas en snake_case con prefijo del módulo: `admin.clientes.index`.
- Rutas de facturación separadas en `routes/facturacion.php`.

### PDF
- Usar `barryvdh/laravel-dompdf`.
- Plantillas en `resources/views/pdf/`.
- Controladores PDF en `App\Http\Controllers\Admin\PDF\`.

### Excel
- Exportaciones en `app/Exports/`, importaciones en `app/Imports/`.
- Implementar `WithHeadings` y `WithStyles` en exportaciones.

### Facturación SUNAT
- Toda comunicación con SUNAT usa la librería **Greenter**.
- Los XMLs firmados se almacenan en storage.
- Manejar correctamente los tipos de comprobante: Factura (01), Boleta (03), NC (07), ND (08), Guía (09).
- Validar IGV (18%) y detracción cuando aplique.

### Notificaciones
- Usar Laravel Notifications para email/base de datos.
- Usar Firebase Cloud Messaging (kreait/laravel-firebase) para push móvil.
- WhatsApp via `netflie/whatsapp-cloud-api` para notificaciones de cobros y alertas.

### Testing
- PHPUnit 11 con tests en `tests/Feature/` y `tests/Unit/`.
- Usar factories para datos de prueba.
- Evitar llamadas reales a APIs externas (SUNAT, GPS, WhatsApp) en tests; usar mocks.

---

## Workflows de desarrollo

```bash
# Frontend
npm run dev          # Vite dev server (Tailwind v4 + hot reload)
npm run build        # Build para producción

# Colas (múltiples queues nombradas)
php artisan queue:work
php artisan queue:work --queue=mail
php artisan queue:work --queue=database
php artisan queue:work --queue=broadcast

# Permisos storage (Linux/servidor)
sudo chmod -Rf 0777 bootstrap/cache/ storage/
```

## Helpers globales (`app/helpers.php`)
- `tipo_cambio($fecha, 'venta'|'compra')` — obtiene el tipo de cambio PEN/USD consultando `FactilizaService` con caché de 6 horas.

---

## Variables de entorno relevantes
- `APP_URL`, `APP_ENV`, `APP_DEBUG`
- `DB_*` — conexión MySQL
- `BROADCAST_DRIVER=pusher`, `PUSHER_*`
- `FIREBASE_*` — credenciales Firebase
- `FACTILIZA_*` — API de facturación
- `GPSWOX_*` — API GPS Wox
- `WHATSAPP_TOKEN`, `WHATSAPP_PHONE_NUMBER_ID`
- `HASHIDS_SALT`, `HASHIDS_LENGTH`

---

## Notas importantes
- El sistema opera bajo legislación **peruana**; los comprobantes siguen el formato UBL 2.1 exigido por SUNAT.
- Las fechas usan zona horaria `America/Lima`.
- Moneda principal: **PEN (Soles)**; soporte secundario para USD con tipo de cambio (`TipoCambio`).
- Los dispositivos GPS se sincronizan con la plataforma Wox; no modificar la lógica de `DeviceHistory` sin revisar el observer correspondiente.
