<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Validación de seguridad para archivos cargados
 * Previene carga de archivos ejecutables y scripts maliciosos
 */
class SecureFileUpload implements ValidationRule
{
    // Extensiones peligrosas BLOQUEADAS
    private const DANGEROUS_EXTENSIONS = [
        'php',
        'phtml',
        'php3',
        'php4',
        'php5',
        'php7',
        'phps',
        'pht',
        'phar',
        'pgif',
        'shtml',
        'htaccess',
        'phtm',
        'cgi',
        'pl',
        'py',
        'jsp',
        'asp',
        'aspx',
        'cer',
        'asa',
        'sh',
        'bat',
        'cmd',
        'com',
        'pif',
        'application',
        'gadget',
        'msi',
        'msp',
        'torrent',
        'exe',
        'scr',
        'jar',
        'vbs'
    ];

    // MIME types peligrosos
    private const DANGEROUS_MIMES = [
        'application/x-php',
        'application/x-httpd-php',
        'application/x-httpd-php-source',
        'application/x-sh',
        'text/x-php',
        'text/x-shellscript'
    ];

    private array $allowedExtensions;
    private ?int $maxSize;

    /**
     * @param array $allowedExtensions Extensiones permitidas (ej: ['jpg', 'png', 'pdf'])
     * @param int|null $maxSize Tamaño máximo en KB (null = sin límite)
     */
    public function __construct(array $allowedExtensions = [], ?int $maxSize = null)
    {
        $this->allowedExtensions = array_map('strtolower', $allowedExtensions);
        $this->maxSize = $maxSize;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            return;
        }

        // 1. Verificar extensión
        $extension = strtolower($value->getClientOriginalExtension());

        if (in_array($extension, self::DANGEROUS_EXTENSIONS)) {
            $fail("El archivo tiene una extensión peligrosa ({$extension}) y ha sido bloqueado por seguridad.");
            return;
        }

        if (!empty($this->allowedExtensions) && !in_array($extension, $this->allowedExtensions)) {
            $fail("Solo se permiten archivos: " . implode(', ', $this->allowedExtensions));
            return;
        }

        // 2. Verificar MIME type
        $mimeType = $value->getMimeType();
        if (in_array($mimeType, self::DANGEROUS_MIMES)) {
            $fail("El tipo de archivo ({$mimeType}) está bloqueado por seguridad.");
            return;
        }

        // 3. Verificar nombre de archivo
        $filename = $value->getClientOriginalName();

        // Detectar doble extensión (.jpg.php)
        if (preg_match('/\.(php|phtml|phar|exe|sh|bat)\./i', $filename)) {
            $fail("El nombre del archivo contiene extensiones peligrosas.");
            return;
        }

        // Detectar caracteres sospechosos
        if (preg_match('/[<>:"|?*\x00-\x1f]/', $filename)) {
            $fail("El nombre del archivo contiene caracteres no permitidos.");
            return;
        }

        // 4. Verificar tamaño
        if ($this->maxSize && $value->getSize() > ($this->maxSize * 1024)) {
            $fail("El archivo no debe superar {$this->maxSize}KB.");
            return;
        }

        // 5. Leer los primeros bytes para detectar scripts PHP
        $handle = fopen($value->getRealPath(), 'r');
        $firstBytes = fread($handle, 256);
        fclose($handle);

        if (preg_match('/<\?php|<\?=|<script/i', $firstBytes)) {
            $fail("El archivo contiene código ejecutable y ha sido bloqueado.");
            return;
        }
    }
}
