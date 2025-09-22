<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SmsQuotaException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(403, $message);
    }
}
