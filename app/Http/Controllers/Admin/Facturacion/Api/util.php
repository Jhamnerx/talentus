<?php

namespace App\Http\Controllers\Admin\Facturacion\Api;

use Exception;
use Greenter\See;
use App\Models\Empresa;
use App\Models\plantilla;
use Greenter\Report\XmlUtils;
use Greenter\Report\PdfReport;
use Greenter\Report\HtmlReport;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\SaleDetail;
use App\Http\Controllers\Controller;
use Greenter\Model\DocumentInterface;
use Illuminate\Support\Facades\Storage;
use Greenter\Model\Response\CdrResponse;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use Greenter\Validator\XmlErrorCodeProvider;
use Greenter\Report\Resolver\DefaultTemplateResolver;


class Util extends Controller
{
    /**
     * @var Util
     */
    private static $current;


    public plantilla $plantilla;

    //  PROPIEDAS PUBLICAS PARA ERRORES Y MENSAJES
    public $estado;
    public $mensaje_error;
    public $mensaje;
    public $nota;
    public $fe_codigo_error;
    public $nombre_xml;
    public $xml_base64;
    public $cdr_base64;
    public $fe_estado;
    public $hash;
    public $hash_cdr;
    public $ticketS;
    public $code_sunat;

    private function __construct()
    {

        $this->plantilla = plantilla::first();
    }

    public static function getInstance(): Util
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }

        return self::$current;
    }

    public function getSee()
    {

        $ruta_certificado = $this->plantilla->empresa->nombre . '/' . $this->plantilla->ruta_cert . '.pem';

        $see = new See();
        if ($this->plantilla->modo = 'local') {

            $see->setService(SunatEndpoints::FE_BETA);
        } else {
            $see->setService(SunatEndpoints::FE_PRODUCCION);
        }

        //        $see->setCodeProvider(new XmlErrorCodeProvider());

        if (!Storage::disk('facturacion')->exists($ruta_certificado)) {
            throw new Exception('No se pudo cargar el certificado');
        }
        $see->setCertificate(Storage::disk('facturacion')->get($ruta_certificado));
        /**
         * Clave SOL
         * Ruc     = 20496172168
         * Usuario = MODDATOS
         * Clave   = moddatos
         */
        $see->setClaveSOL($this->plantilla->ruc, $this->plantilla->sunat_datos['usuario_sol_sunat'], $this->plantilla->sunat_datos['clave_sol_sunat']);
        //$see->setCachePath(__DIR__ . '/../cache');

        return $see;
    }

    public function getSeeApi()
    {
        $api = new \Greenter\Api([
            'auth' => 'https://gre-test.nubefact.com/v1',
            'cpe' => 'https://gre-test.nubefact.com/v1',
        ]);
        $certificate = file_get_contents(__DIR__ . '/../resources/cert.pem');
        if ($certificate === false) {
            throw new Exception('No se pudo cargar el certificado');
        }
        return $api->setBuilderOptions([
            'strict_variables' => true,
            'optimizations' => 0,
            'debug' => true,
            'cache' => false,
        ])
            ->setApiCredentials('test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==')
            ->setClaveSOL('20161515648', 'MODDATOS', 'MODDATOS')
            ->setCertificate($certificate);
    }

    public function getCompany(): \Greenter\Model\Company\Company
    {
        return (new \Greenter\Model\Company\Company())
            ->setRuc($this->plantilla->ruc)
            ->setRazonSocial($this->plantilla->razon_social)
            ->setNombreComercial($this->plantilla->nombre_comercial)
            ->setAddress((new Address())
                ->setUbigueo($this->plantilla->direccion['ubigeo'])
                ->setDistrito($this->plantilla->direccion['distrito'])
                ->setProvincia($this->plantilla->direccion['provincia'])
                ->setDepartamento($this->plantilla->direccion['departamento'])
                ->setCodLocal('0000')
                ->setDireccion($this->plantilla->direccion['direccion']))
            ->setEmail($this->plantilla->correo)
            ->setTelephone($this->plantilla->telefono);
    }


    public function showResponse(DocumentInterface $document, CdrResponse $cdr)
    {

        $this->nombre_xml = $document->getName();
        $this->code_sunat = (int)$cdr->getCode();
        $code = (int)$cdr->getCode();

        if ($code === 0) {
            //SI EL CODIGO ES 0 EL ESTADO DE LA FACTURA ES
            $this->estado = 'ESTADO: ACEPTADA';
            $this->fe_estado = '1';

            if (count($cdr->getNotes()) > 0) {

                $this->estado = 'ESTADO: OBSERVACIONES:';
                // Corregir estas observaciones en siguientes emisiones.
                $this->nota = $cdr->getNotes();
                $this->mensaje = $cdr->getDescription() . ' CON OBSERVACIONES';
            }
        } else if ($code >= 2000 && $code <= 3999) {
            //SI EL CODIGO ESTA ENTRE ESTOS SE RECOGE EL MENSAJE Y EL CODIGO DE ERROR
            $this->estado = 'ESTADO: RECHAZADA';
            $this->mensaje_error = $cdr->getDescription();
            $this->fe_codigo_error = $code;
            $this->$this->fe_estado = (int)$cdr->getCode();
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            $this->mensaje = 'Excepción';
        }

        $this->mensaje = $cdr->getDescription();
        // $this->hash = $cdr->getHash();
        $this->hash = $this->getHash($document);

        return $this->getResults();
    }

    public function getResults()
    {
        $results
            =  [
                'estado_texto' => $this->estado,
                'fe_mensaje_sunat' => $this->mensaje,
                'fe_mensaje_error' => $this->mensaje_error,
                'nota' => $this->nota,
                'fe_codigo_error' => $this->fe_codigo_error,
                'nombre_xml' => $this->nombre_xml,
                'xml_base64' => $this->xml_base64,
                'cdr_base64' => $this->cdr_base64,
                'fe_estado' => $this->fe_estado,
                'hash' => $this->hash,
                'hash_cdr' => $this->hash_cdr,
                'code_sunat' => $this->code_sunat,

            ];
        return $results;
    }

    public function getErrorResponse(\Greenter\Model\Response\Error $error)
    {
        $results
            =  [
                'estado_texto' => 'ESTADO: RECHAZADA',
                'fe_mensaje_sunat' => $this->mensaje,
                'fe_mensaje_error' => $error->getMessage(),
                'nota' => $this->nota,
                'fe_codigo_error' => $error->getCode(),
                'nombre_xml' => $this->nombre_xml,
                'xml_base64' => $this->xml_base64,
                'cdr_base64' => $this->cdr_base64,
                'fe_estado' => 0,
                'hash' => $this->hash,
                'hash_cdr' => $this->hash_cdr,
                'code_sunat' => $this->code_sunat,

            ];
        return $results;
    }

    public function writeXml(DocumentInterface $document, ?string $xml): void
    {
        $this->writeFile($document->getName() . '.xml', $xml, 'xml');
        $this->xml_base64 = base64_encode($xml);
    }

    public function writeXmlOnly(DocumentInterface $document, ?string $xml)
    {
        $this->writeFile($document->getName() . '.xml', $xml, 'xml');
        return base64_encode($xml);
    }


    public function writeCdr(DocumentInterface $document, ?string $zip): void
    {
        $this->writeFile('R-' . $document->getName() . '.zip', $zip, 'cdr');
        $this->cdr_base64 = base64_encode($zip);
    }

    public function writeFile(?string $filename, ?string $content, $type): void
    {
        if (getenv('GREENTER_NO_FILES')) {
            return;
        }
        if ($type == 'xml') {

            $fileDir = $this->plantilla->empresa->nombre . "/" . $this->plantilla->ruta_xml;
        } else {
            $fileDir = $this->plantilla->empresa->nombre . "/" . $this->plantilla->ruta_cdr;
        }



        if (!Storage::disk('facturacion')->exists($fileDir)) {

            Storage::makeDirectory($fileDir);
        }

        Storage::disk('facturacion')->put($fileDir . DIRECTORY_SEPARATOR . $filename, $content);
    }

    public function getPdf(DocumentInterface $document): ?string
    {
        $html = new HtmlReport('', [
            'cache' => __DIR__ . '/../cache',
            'strict_variables' => true,
        ]);
        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);

        $render = new PdfReport($html);
        $render->setOptions([
            'no-outline',
            'print-media-type',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'footer-html' => __DIR__ . '/../resources/footer.html',
        ]);
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        $hash = $this->getHash($document);
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';

        $pdf = $render->render($document, $params);

        if ($pdf === null) {
            $error = $render->getExporter()->getError();
            echo 'Error: ' . $error;
            exit();
        }

        // Write html
        $this->writeFile($document->getName() . '.html', $render->getHtml());

        return $pdf;
    }



    /**
     * @param SaleDetail $item
     * @param int $count
     * @return array<SaleDetail>
     */
    public function generator(SaleDetail $item, int $count): array
    {
        $items = [];

        for ($i = 0; $i < $count; $i++) {
            $items[] = $item;
        }

        return $items;
    }

    public function showPdf(?string $content, ?string $filename): void
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));

        echo $content;
    }

    public static function getPathBin(): string
    {
        $path = __DIR__ . '/../vendor/bin/wkhtmltopdf';
        if (self::isWindows()) {
            $path .= '.exe';
        }

        return $path;
    }

    public static function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    private function getHash(DocumentInterface $document): ?string
    {
        $see = $this->getSee('');
        $xml = $see->getXmlSigned($document);

        return (new XmlUtils())->getHashSign($xml);
    }

    /**
     * @return array<string, array<string, array<int, array<string, string>>|bool|string>>
     */
    private static function getParametersPdf(): array
    {
        $logo = file_get_contents(__DIR__ . '/../resources/logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => 'Telf: <b>(056) 123375</b>',
                'extras' => [
                    ['name' => 'FORMA DE PAGO', 'value' => 'Contado'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
            ]
        ];
    }
}
