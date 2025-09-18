<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PersianMobileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^09\d{9}$/';
        if (! is_string($value) || ! preg_match($pattern, $value)) {
            $fail(__('The :attribute must be a valid Iranian mobile number (starting with 09).'));
        }
    }
}
