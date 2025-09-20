<?php

namespace App\Dto;

class SmsSentResult
{
    public function __construct(
        protected bool $ok
    )
    {
        //
    }

    public function isOk(): bool
    {
        return $this->ok;
    }
}
