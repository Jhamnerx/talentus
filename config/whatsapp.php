<?php

return [
    'ip_protection_enabled' => env('IP_PROTECTION_ENABLED', false),
    'allowed_ips' => env('ALLOWED_IPS', '127.0.0.1,::1'),
    'allowed_domains' => env('ALLOWED_DOMAINS', 'localhost'),
    'node_server_url' => env('NODE_SERVER_URL', 'http://localhost:3000'),
    'socket_url' => env('SOCKET_URL', 'http://localhost:3000'),
    'server_url' => env('WA_URL_SERVER', 'http://localhost:3000'),
];
