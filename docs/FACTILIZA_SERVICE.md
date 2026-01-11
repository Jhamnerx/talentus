# Servicio Factiliza

Servicio para consumir la API de Factiliza desde cualquier parte de la aplicación Laravel.

## Configuración

1. Agregar el token de Factiliza al archivo `.env`:

```env
FACTILIZA_TOKEN=tu_token_aqui
FACTILIZA_BASE_URL=https://api.factiliza.com/v1
```

## Uso

Simplemente instancia el servicio y usa sus métodos:

```php
use App\Services\FactilizaService;

// Instanciar el servicio
$factiliza = new FactilizaService();

// Consultar DNI
$resultado = $factiliza->consultarDni('27427864');

// Consultar RUC
$resultado = $factiliza->consultarRuc('20552103816');

// Tipo de cambio
$cambio = $factiliza->consultarTipoCambio(); // Hoy
$cambio = $factiliza->consultarTipoCambio('2024-01-01'); // Fecha específica
```

### En Controladores

```php
use App\Services\FactilizaService;

class ClienteController extends Controller
{
    public function consultar($dni)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($dni);

        return response()->json($resultado);
    }
}
```

### En Componentes Livewire

```php
use App\Services\FactilizaService;
use Livewire\Component;

class MiComponente extends Component
{
    public $dni;
    public $nombres;
    public $apellido_paterno;

    public function consultarDni()
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($this->dni);

        if ($resultado['success']) {
            $data = $resultado['data'];
            $this->nombres = $data['nombres'];
            $this->apellido_paterno = $data['apellido_paterno'];
        }
    }
}
```

## Métodos Disponibles

### Consultas de Identidad

#### consultarDni(string $dni)

Consulta información de un DNI peruano.

```php
$resultado = $factiliza->consultarDni('27427864');
// Retorna: nombres, apellido_paterno, apellido_materno, departamento, provincia, distrito, direccion, ubigeo
```

#### consultarCarnetExtranjeria(string $cee)

Consulta información de un Carnet de Extranjería.

```php
$resultado = $factiliza->consultarCarnetExtranjeria('001077238');
// Retorna: numero, nombres, apellido_paterno, apellido_materno
```

### Consultas de Empresas

#### consultarRuc(string $ruc)

Consulta información de un RUC.

```php
$resultado = $factiliza->consultarRuc('20552103816');
// Retorna: nombre_o_razon_social, tipo_contribuyente, estado, condicion, direccion, ubigeo
```

#### consultarRucEstablecimientos(string $ruc)

Consulta los establecimientos (anexos) de un RUC.

```php
$resultado = $factiliza->consultarRucEstablecimientos('20552103816');
// Retorna: array de establecimientos con codigo, tipo_establecimiento, direccion, ubigeo
```

#### consultarRucRepresentantes(string $ruc)

Consulta los representantes legales de un RUC.

```php
$resultado = $factiliza->consultarRucRepresentantes('20552103816');
// Retorna: array de representantes con tipo_de_documento, numero_de_documento, nombre, cargo, fecha_desde
```

### Consultas Vehiculares

#### consultarPlaca(string $placa)

Consulta información de una placa vehicular.

```php
$resultado = $factiliza->consultarPlaca('F3H792');
// Retorna: placa, marca, modelo, serie, color, motor, vin
```

#### consultarSoat(string $placa)

Consulta información del SOAT de un vehículo.

```php
$resultado = $factiliza->consultarSoat('F3H792');
// Retorna: información del SOAT vigente
```

#### consultarLicenciaConducir(string $licencia)

Consulta información de una licencia de conducir.

```php
$resultado = $factiliza->consultarLicenciaConducir('L12345678');
// Retorna: información de la licencia de conducir
```

### Tipo de Cambio

#### consultarTipoCambio(?string $fecha = null, bool $forzarApi = false)

Consulta el tipo de cambio del día o de una fecha específica.

**Caché inteligente**: Primero busca en la base de datos local. Si no existe, consulta la API y guarda el resultado para futuras consultas, ahorrando llamadas a la API.

```php
// Tipo de cambio de hoy (desde DB si existe, sino desde API)
$resultado = $factiliza->consultarTipoCambio();

// Tipo de cambio de una fecha específica
$resultado = $factiliza->consultarTipoCambio('2024-01-01');

// Forzar consulta a la API ignorando caché
$resultado = $factiliza->consultarTipoCambio('2024-01-01', true);

// Respuesta incluye indicador de origen
// desde_cache: true = obtenido desde DB
// desde_cache: false = obtenido desde API y guardado
// Retorna: fecha, compra, venta, desde_cache
```

````

### Consultas SUNAT

#### consultarCPE(array $data)

Consulta un Comprobante de Pago Electrónico (CPE) en SUNAT.

```php
$resultado = $factiliza->consultarCPE([
    'numRuc' => '20123456789',
    'tipoDocumento' => '01', // 01=factura, 03=boleta
    'numSerieComprobante' => 'F001',
    'numDocumentoComprobante' => '00000123'
]);
````

#### descargarXML(string $numRuc, string $tipoDocumento, string $serie, string $numero)

Descarga el XML de un comprobante desde SUNAT.

```php
$xml = $factiliza->descargarXML('20123456789', '01', 'F001', '00000123');
```

#### descargarPDF(string $numRuc, string $tipoDocumento, string $serie, string $numero)

Descarga el PDF de un comprobante desde SUNAT.

```php
$pdf = $factiliza->descargarPDF('20123456789', '01', 'F001', '00000123');
```

#### descargarCDR(string $numRuc, string $tipoDocumento, string $serie, string $numero)

Descarga el CDR (Constancia de Recepción) de un comprobante desde SUNAT.

```php
$cdr = $factiliza->descargarCDR('20123456789', '01', 'F001', '00000123');
```

#### descargarGuiaJSON(string $numRuc, string $tipoDocumento, string $serie, string $numero)

Descarga el JSON de una Guía de Remisión desde SUNAT.

```php
$guia = $factiliza->descargarGuiaJSON('20123456789', '09', 'T001', '00000123');
```

#### descargarGuiaXML(string $numRuc, string $tipoDocumento, string $serie, string $numero)

Descarga el XML de una Guía de Remisión desde SUNAT.

```php
$guia = $factiliza->descargarGuiaXML('20123456789', '09', 'T001', '00000123');
```

## Formato de Respuesta

Todas las respuestas de la API tienen el siguiente formato:

```php
[
    'status' => 200,           // Código HTTP
    'success' => true,         // Estado de éxito
    'message' => 'Exito',      // Mensaje descriptivo
    'data' => [...]            // Datos de la respuesta
]
```

### Manejo de Errores

El servicio captura excepciones y retorna un formato consistente:

```php
[
    'status' => 500,
    'success' => false,
    'message' => 'Error al consultar la API: ...',
    'data' => null
]
```

### Ejemplo de Manejo de Respuesta

```php
$resultado = $factiliza->consultarDni('27427864');

if ($resultado['success'] && $resultado['status'] === 200) {
    $data = $resultado['data'];

    // Usar los datos
    $nombreCompleto = $data['nombre_completo'];
    $direccion = $data['direccion_completa'];

} else {
    // Manejar error
    $error = $resultado['message'];
    Log::error('Error al consultar DNI: ' . $error);
}
```

## Códigos de Tipo de Documento SUNAT

-   `01` - Factura
-   `03` - Boleta
-   `07` - Nota de Crédito
-   `08` - Nota de Débito
-   `09` - Guía de Remisión Remitente

## Notas Importantes

1. El token de Factiliza debe configurarse en el archivo `.env`
2. El servicio registra automáticamente los errores en el log de Laravel
3. Todos los métodos retornan un array con la estructura estándar de respuesta
4. El servicio está registrado como singleton para reutilizar la misma instancia
