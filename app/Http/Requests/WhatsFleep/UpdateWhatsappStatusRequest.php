<?php

namespace App\Http\Requests\WhatsFleep;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWhatsappStatusRequest extends FormRequest
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
            'status' => ['required', Rule::in(['sent', 'delivered', 'read', 'failed'])],
        ];
    }
}
