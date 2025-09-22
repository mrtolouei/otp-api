<?php

namespace App\Http\Requests\Services;

use App\Rules\PersianMobileRule;
use Illuminate\Foundation\Http\FormRequest;

class OtpSmsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => [
                'required',
                'string',
                new PersianMobileRule(),
            ]
        ];
    }
}
