<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/vinkla/laravel-hashids
 */

use App\Models\Actas;
use App\Models\Certificados;
use App\Models\CertificadosVelocimetros;
use App\Models\Contratos;
use App\Models\Recibos;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [
        Actas::class => [
            'salt' => Actas::class . config('app.key'),
            'length' => '20',
            'alphabet' => 'XKyIAR7mgt8jD2vbqPrOSVenNGpiYLx4M61T',
        ],
        Certificados::class => [
            'salt' => Certificados::class . config('app.key'),
            'length' => '20',
            'alphabet' => 'yLJWP79M8rYVqbn1NXjulO6IUDdvekRQGo40',
        ],
        CertificadosVelocimetros::class => [
            'salt' => CertificadosVelocimetros::class . config('app.key'),
            'length' => '20',
            'alphabet' => 'asqtW3eDRIxB65GYl7UVLS1dybn9XrKTZ4zO',
        ],
        Contratos::class => [
            'salt' => Contratos::class . config('app.key'),
            'length' => '20',
            'alphabet' => 'ADyQWE8mgt7jF2vbnPrKLJenHVpiUIq4M12T',
        ],
        Recibos::class => [
            'salt' => Recibos::class . config('app.key'),
            'length' => '20',
            'alphabet' => 's0DxOFtEYEnuKPmP08Ch6A1iHlLmBTBVWms5',
        ],
        'main' => [
            'salt' => 'your-salt-string',
            'length' => 'your-length-integer',
            // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

        'alternative' => [
            'salt' => 'your-salt-string',
            'length' => 'your-length-integer',
            // 'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

    ],

];
