<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedClientException;
use App\Models\ClientToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader('authorization')) {
            $bearerToken = $request->header('authorization');
            $token = substr($bearerToken, 7);
            $client = ClientToken::query()->where('token', $token)->first();
            if ($client) {
                $request->merge([
                   'client_token_id' => $client->getAttribute('id'),
                ]);
                return $next($request);
            }
        }
        throw new UnauthorizedClientException(__('Unauthorized token'));
    }
}
