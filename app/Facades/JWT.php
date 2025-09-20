<?php

namespace App\Facades;

use App\Services\JwtService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string encode(array $payload)
 * @method static array decode(string $jwt)
 */
class JWT extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return JwtService::class;
    }
}
