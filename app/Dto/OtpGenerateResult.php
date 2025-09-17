<?php

namespace App\Dto;

class OtpGenerateResult
{
    public function __construct(
        protected string $uuid,
        protected string $expiresAt,
    )
    {
        //
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }
}
