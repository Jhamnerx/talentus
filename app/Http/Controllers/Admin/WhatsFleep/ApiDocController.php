<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;

class ApiDocController extends Controller
{
    public function index()
    {
        $baseUrl   = config('whatsapp.node_server_url');
        $endpoints = [
            [
                'method'      => 'POST',
                'url'         => '/api/send-message',
                'description' => 'Enviar mensaje de texto',
                'body'        => [
                    'token'   => 'device1',
                    'number'  => '5491234567890',
                    'message' => 'Hola desde Talentus WA',
                ],
            ],
            [
                'method'      => 'POST',
                'url'         => '/api/send-media',
                'description' => 'Enviar multimedia (imagen, video, audio, documento)',
                'body'        => [
                    'token'   => 'device1',
                    'number'  => '5491234567890',
                    'type'    => 'image',
                    'url'     => 'https://example.com/image.jpg',
                    'caption' => 'Mira esta imagen',
                ],
            ],
            [
                'method'      => 'GET',
                'url'         => '/api/device-status/:token',
                'description' => 'Verificar estado del dispositivo',
                'body'        => null,
            ],
            [
                'method'      => 'POST',
                'url'         => '/api/send-bulk',
                'description' => 'Envío masivo de mensajes',
                'body'        => [
                    'token'    => 'device1',
                    'delay'    => 2000,
                    'messages' => [
                        ['number' => '5491234567890', 'message' => 'Mensaje 1'],
                        ['number' => '5499876543210', 'message' => 'Mensaje 2'],
                    ],
                ],
            ],
        ];

        return view('admin.whats-fleep.api-docs.index', compact('baseUrl', 'endpoints'));
    }
}
