<?php

namespace App\Dto;

class OtpVerifyResult
{
    public function __construct(
        protected bool $ok,
        protected ?string $mobile = null,
    )
    {
        //
    }

    public function isOk(): bool
    {
        return $this->ok;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }
}
