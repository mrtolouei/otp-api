<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyClientToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $tokenWithBearer = $request->header('Authorization');
        $token = substr($tokenWithBearer, 7);
        if ($token) {
            $company = Company::query()->where('client_token', $token)->first();
            if ($company) {
                $request->merge([
                    'company_uuid' => $company->uuid,
                ]);
                return $next($request);
            }
        }
        throw new UnauthorizedException('Unauthorized');
    }
}
