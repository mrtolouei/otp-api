<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class OtpVerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uuid' => 'required|string',
            'code' => 'required|numeric|digits:5',
        ];
    }
}
