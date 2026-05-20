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
                'path'        => '/api/send-message',
                'description' => 'Enviar mensaje de texto',
                'params'      => [
                    ['name' => 'token',   'type' => 'string', 'required' => true,  'description' => 'Identificador del dispositivo'],
                    ['name' => 'number',  'type' => 'string', 'required' => true,  'description' => 'Número de destino (con código de país)'],
                    ['name' => 'message', 'type' => 'string', 'required' => true,  'description' => 'Texto del mensaje'],
                ],
                'example'     => json_encode(['token' => 'device1', 'number' => '51987654321', 'message' => 'Hola desde Talentus'], JSON_PRETTY_PRINT),
            ],
            [
                'method'      => 'POST',
                'path'        => '/api/send-image',
                'description' => 'Enviar imagen',
                'params'      => [
                    ['name' => 'token',    'type' => 'string', 'required' => true,  'description' => 'Identificador del dispositivo'],
                    ['name' => 'number',   'type' => 'string', 'required' => true,  'description' => 'Número de destino'],
                    ['name' => 'imageUrl', 'type' => 'string', 'required' => true,  'description' => 'URL pública de la imagen'],
                    ['name' => 'caption',  'type' => 'string', 'required' => false, 'description' => 'Texto opcional debajo de la imagen'],
                ],
                'example'     => json_encode(['token' => 'device1', 'number' => '51987654321', 'imageUrl' => 'https://example.com/img.jpg', 'caption' => 'Mira esto'], JSON_PRETTY_PRINT),
            ],
            [
                'method'      => 'POST',
                'path'        => '/api/send-video',
                'description' => 'Enviar video',
                'params'      => [
                    ['name' => 'token',    'type' => 'string', 'required' => true,  'description' => 'Identificador del dispositivo'],
                    ['name' => 'number',   'type' => 'string', 'required' => true,  'description' => 'Número de destino'],
                    ['name' => 'videoUrl', 'type' => 'string', 'required' => true,  'description' => 'URL pública del video'],
                    ['name' => 'caption',  'type' => 'string', 'required' => false, 'description' => 'Texto opcional'],
                ],
                'example'     => json_encode(['token' => 'device1', 'number' => '51987654321', 'videoUrl' => 'https://example.com/video.mp4', 'caption' => ''], JSON_PRETTY_PRINT),
            ],
            [
                'method'      => 'POST',
                'path'        => '/api/send-audio',
                'description' => 'Enviar audio',
                'params'      => [
                    ['name' => 'token',    'type' => 'string', 'required' => true, 'description' => 'Identificador del dispositivo'],
                    ['name' => 'number',   'type' => 'string', 'required' => true, 'description' => 'Número de destino'],
                    ['name' => 'audioUrl', 'type' => 'string', 'required' => true, 'description' => 'URL pública del audio (mp3/ogg)'],
                ],
                'example'     => json_encode(['token' => 'device1', 'number' => '51987654321', 'audioUrl' => 'https://example.com/audio.mp3'], JSON_PRETTY_PRINT),
            ],
            [
                'method'      => 'POST',
                'path'        => '/api/send-document',
                'description' => 'Enviar documento',
                'params'      => [
                    ['name' => 'token',       'type' => 'string', 'required' => true,  'description' => 'Identificador del dispositivo'],
                    ['name' => 'number',      'type' => 'string', 'required' => true,  'description' => 'Número de destino'],
                    ['name' => 'documentUrl', 'type' => 'string', 'required' => true,  'description' => 'URL pública del documento'],
                    ['name' => 'fileName',    'type' => 'string', 'required' => false, 'description' => 'Nombre del archivo a mostrar'],
                ],
                'example'     => json_encode(['token' => 'device1', 'number' => '51987654321', 'documentUrl' => 'https://example.com/file.pdf', 'fileName' => 'contrato.pdf'], JSON_PRETTY_PRINT),
            ],
            [
                'method'      => 'GET',
                'path'        => '/api/device-status/:token',
                'description' => 'Verificar estado del dispositivo',
                'params'      => [
                    ['name' => 'token', 'type' => 'string', 'required' => true, 'description' => 'Identificador del dispositivo (en la URL)'],
                ],
                'example'     => null,
            ],
        ];

        return view('admin.whats-fleep.api-docs.index', compact('baseUrl', 'endpoints'));
    }
}
