<?php

namespace App\Dto;

class OtpVerifyResult
{
    protected ?string $mobile = null;

    public function __construct(protected bool $ok)
    {
        //
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
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
