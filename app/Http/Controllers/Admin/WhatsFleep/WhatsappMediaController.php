<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WhatsappMediaController extends Controller
{
    /**
     * Transmite el adjunto de un mensaje desde el disco privado.
     * La ruta exige sesión (middleware auth); el filtrado por rol/conversación
     * se endurece en SP#3 (Policies). Nunca expone el archivo por URL pública.
     */
    public function show(WhatsappMessage $message): StreamedResponse|Response
    {
        if (empty($message->media_path)) {
            abort(404);
        }

        $disk = Storage::disk(config('whatsapp.media_disk', 'local'));

        if (! $disk->exists($message->media_path)) {
            abort(404);
        }

        return $disk->response(
            $message->media_path,
            $message->file_name,
            ['Content-Type' => $message->mime_type ?: 'application/octet-stream']
        );
    }
}
