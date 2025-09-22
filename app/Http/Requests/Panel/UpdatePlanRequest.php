<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'token_quota' => 'required|integer|min:1',
            'sms_quota' => 'required|integer|min:1',
            'voice_quota' => 'required|integer|min:1',
            'months_duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ];
    }
}
