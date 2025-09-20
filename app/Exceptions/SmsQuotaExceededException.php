<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SmsQuotaExceededException extends HttpException
{
    public function __construct(string $message, int $statusCode = 403)
    {
        parent::__construct($statusCode, $message);
    }
}
