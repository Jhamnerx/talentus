<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreHistoryBatchRequest extends FormRequest
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
            'messages' => ['required', 'array', 'min:1'],
            'messages.*.wa_message_id' => ['required', 'string'],
            'messages.*.from_me' => ['required', 'boolean'],
            'messages.*.from' => ['required', 'string'],
            'messages.*.wa_jid' => ['required', 'string'],
            'messages.*.push_name' => ['nullable', 'string'],
            'messages.*.type' => ['required', Rule::in(['text', 'image', 'audio', 'video', 'document', 'location', 'contact', 'sticker'])],
            'messages.*.body' => ['nullable', 'string'],
            'messages.*.timestamp' => ['nullable', 'integer'],
        ];
    }
}
