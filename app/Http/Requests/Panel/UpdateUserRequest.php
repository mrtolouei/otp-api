<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');
        return [
            'mobile' => 'required|numeric|unique:users,mobile,' . $user,
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'national_id' => 'required|numeric',
            'birthdate' => 'nullable|date',
        ];
    }
}
