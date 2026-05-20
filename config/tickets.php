<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Correo para comunicaciones con el cliente
    |--------------------------------------------------------------------------
    | Configura TICKET_FROM_EMAIL y TICKET_FROM_NAME en el .env para usar un
    | correo exclusivo para la comunicación con clientes desde el módulo
    | de tickets. Si no se definen, se usan los valores de MAIL_FROM_*.
    */

    'from_email' => env('TICKET_FROM_EMAIL', env('MAIL_FROM_ADDRESS')),

    'from_name' => env('TICKET_FROM_NAME', env('MAIL_FROM_NAME', 'Soporte')),

];
