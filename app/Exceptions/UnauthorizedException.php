<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    public function __construct(string $message, int $statusCode = 401)
    {
        parent::__construct($statusCode, $message);
    }
}
