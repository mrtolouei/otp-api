<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => 'required|numeric|unique:users,mobile',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'national_id' => 'required|numeric',
            'birthdate' => 'nullable|date',
        ];
    }
}
