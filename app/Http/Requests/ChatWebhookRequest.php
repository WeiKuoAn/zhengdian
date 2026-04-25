<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatWebhookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'text' => ['nullable', 'string'],
            'message' => ['nullable', 'string'],
            'command' => ['nullable', 'string'],
            'channel_id' => ['nullable', 'string'],
            'user_id' => ['nullable', 'string'],
            'username' => ['nullable', 'string'],
            'payload' => ['nullable', 'array'],
        ];
    }
}
