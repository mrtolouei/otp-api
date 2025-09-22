<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedClientException extends HttpException
{
    public function __construct(string $message = '')
    {
        parent::__construct(401, $message);
    }
}
