<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIncomingWhatsappRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'device' => ['required', 'string'],
            'wa_message_id' => ['required', 'string'],
            'from' => ['required', 'string'],
            'wa_jid' => ['nullable', 'string'],
            'push_name' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['text', 'image', 'audio', 'video', 'document', 'location', 'contact', 'sticker'])],
            'body' => ['nullable', 'string'],
            'media_path' => ['nullable', 'string'],
            'mime_type' => ['nullable', 'string'],
            'file_name' => ['nullable', 'string'],
            'file_size' => ['nullable', 'integer'],
            'timestamp' => ['nullable', 'integer'],
            'is_group' => ['nullable', 'boolean'],
        ];
    }
}
