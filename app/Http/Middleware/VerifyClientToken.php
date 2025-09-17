<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class VerifyClientToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if ($token) {
            $company = Company::query()->where('client_token', $token)->first();
            if ($company) {
                $request->merge([
                    'company_uuid' => $company->uuid,
                ]);
                return $next($request);
            }
        }
        throw new UnauthorizedHttpException('Unauthorized');
    }
}
