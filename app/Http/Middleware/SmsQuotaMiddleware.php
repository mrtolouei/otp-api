<?php

namespace App\Http\Middleware;

use App\Exceptions\SmsQuotaException;
use App\Models\ClientToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsQuotaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->input('client_token_id')) {
            $clientToken = ClientToken::with(['user'])->findOrFail($request->input('client_token_id'));
            if ($clientToken->user) {
                $hasQuota = $clientToken->user->subscription()->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                })->where('sms_remaining', '>', 0)->exists();
                if ($hasQuota) {
                    return $next($request);
                }
            }
        }
        throw new SmsQuotaException(__('You have no remaining SMS credits.'));
    }
}
