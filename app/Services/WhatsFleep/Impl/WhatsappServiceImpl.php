<?php

namespace App\Services\WhatsFleep\Impl;

use App\Services\WhatsFleep\WhatsappService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class WhatsappServiceImpl implements WhatsappService
{
    private Client $client;
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.server_url', 'http://localhost:3000');

        $this->client = new Client([
            'base_uri'    => $this->baseUrl,
            'timeout'     => 60.0,
            'verify'      => false,
            'http_errors' => false,
        ]);
    }

    private function request(string $method, string $endpoint, array $data = []): object
    {
        try {
            $response = $this->client->request($method, $endpoint, [
                'form_params' => $data,
                'headers'     => ['Accept' => 'application/json'],
            ]);

            $body = json_decode($response->getBody()->getContents());

            return $body ?? (object)['status' => false, 'message' => 'Respuesta inválida del servidor'];
        } catch (GuzzleException $e) {
            Log::error('WhatsApp Service Error: ' . $e->getMessage());

            return (object)['status' => false, 'message' => 'Error de conexión: ' . $e->getMessage()];
        }
    }

    public function fetchGroups($device): object
    {
        return $this->request('POST', '/api/fetch-groups', ['token' => $device->body]);
    }

    public function fetchContacts($device): object
    {
        return $this->request('POST', '/api/fetch-contacts', ['token' => $device->body]);
    }

    public function sendText($token, $number, $message): object
    {
        return $this->request('POST', '/api/send-message', [
            'token'   => $token,
            'number'  => $number,
            'message' => $message,
        ]);
    }

    public function syncHistory($token, $jid, $count, array $oldestMsgKey, $oldestMsgTimestamp): object
    {
        return $this->request('POST', '/api/sync-history', [
            'token'              => $token,
            'jid'                => $jid,
            'count'              => $count,
            // form_params no soporta objetos anidados con extended:false en Express;
            // se serializa como JSON, igual que 'buttons'/'sections' en otros métodos.
            'oldestMsgKey'       => json_encode($oldestMsgKey),
            'oldestMsgTimestamp' => $oldestMsgTimestamp,
        ]);
    }

    public function sendMedia($token, $number, $type, $url, $caption = '', $fileName = ''): object
    {
        return $this->request('POST', '/api/send-media', [
            'token'    => $token,
            'number'   => $number,
            'type'     => $type,
            'url'      => $url,
            'caption'  => $caption,
            'fileName' => $fileName,
        ]);
    }

    public function sendImageBase64($token, $number, $base64Image, $caption = ''): object
    {
        return $this->request('POST', '/api/send-image-base64', [
            'token'   => $token,
            'number'  => $number,
            'base64'  => $base64Image,
            'caption' => $caption,
        ]);
    }

    public function sendButton($token, $number, $message, $buttons, $footer = '', $image = ''): object
    {
        return $this->request('POST', '/api/send-button', [
            'token'   => $token,
            'number'  => $number,
            'message' => $message,
            'buttons' => json_encode($buttons),
            'footer'  => $footer,
            'image'   => $image,
        ]);
    }

    public function sendTemplate($token, $number, $message, $buttons, $footer = '', $image = ''): object
    {
        return $this->request('POST', '/api/send-template', [
            'token'   => $token,
            'number'  => $number,
            'message' => $message,
            'buttons' => json_encode($buttons),
            'footer'  => $footer,
            'image'   => $image,
        ]);
    }

    public function sendList($token, $number, $message, $sections, $footer = '', $title = '', $buttonText = ''): object
    {
        return $this->request('POST', '/api/send-list', [
            'token'      => $token,
            'number'     => $number,
            'message'    => $message,
            'sections'   => json_encode($sections),
            'footer'     => $footer,
            'title'      => $title,
            'buttonText' => $buttonText,
        ]);
    }

    public function sendContact($token, $number, $contactName, $contactNumber): object
    {
        return $this->request('POST', '/api/send-contact', [
            'token'         => $token,
            'number'        => $number,
            'contactName'   => $contactName,
            'contactNumber' => $contactNumber,
        ]);
    }

    public function sendLocation($token, $number, $latitude, $longitude, $name = ''): object
    {
        return $this->request('POST', '/api/send-location', [
            'token'     => $token,
            'number'    => $number,
            'latitude'  => $latitude,
            'longitude' => $longitude,
            'name'      => $name,
        ]);
    }

    public function sendBulk($token, $messages, $delay = 1000): object
    {
        return $this->request('POST', '/api/send-bulk', [
            'token'    => $token,
            'messages' => json_encode($messages),
            'delay'    => $delay,
        ]);
    }

    public function checkStatus($token): object
    {
        try {
            $response = $this->client->get("/api/device-status/{$token}");
            $body = json_decode($response->getBody()->getContents());

            return $body ?? (object)['status' => false];
        } catch (GuzzleException $e) {
            return (object)['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function checkWhatsapp($token, $number): object
    {
        return $this->request('POST', '/api/check-whatsapp', [
            'token'  => $token,
            'number' => $number,
        ]);
    }
}
