<?php

namespace App\Http\Requests;

use App\Rules\PersianMobileRule;
use Illuminate\Foundation\Http\FormRequest;

class SmsOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => [
                'required',
                'string',
                new PersianMobileRule(),
            ]
        ];
    }
}
