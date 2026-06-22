<?php

return [
    'ip_protection_enabled' => env('IP_PROTECTION_ENABLED', false),
    'allowed_ips' => env('ALLOWED_IPS', '127.0.0.1,::1'),
    'allowed_domains' => env('ALLOWED_DOMAINS', 'localhost'),
    'node_server_url' => env('NODE_SERVER_URL', 'http://localhost:3000'),
    'socket_url' => env('SOCKET_URL', 'http://localhost:3000'),
    'server_url' => env('WA_URL_SERVER', 'http://localhost:3000'),

    // Omnicanal SP#1
    'internal_token' => env('WHATSAPP_INTERNAL_TOKEN'),
    'default_empresa_id' => (int) env('WHATSAPP_DEFAULT_EMPRESA_ID', 1),
    'media_disk' => env('WHATSAPP_MEDIA_DISK', 'local'),
    'media_path' => 'whatsapp',
    'country_code' => env('WHATSAPP_COUNTRY_CODE', '51'),
];
