<?php

namespace App\Http\Middleware;

use App\Exceptions\SmsQuotaExceededException;
use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasSmsQuota
{
    public function handle(Request $request, Closure $next): Response
    {
        $company = Company::with(['user.activeSubscription'])
            ->where('uuid', $request->input('company_uuid'))
            ->first();
        if ($company && $company->user->activeSubscription?->sms_remaining > 0) {
            return $next($request);
        }
        throw new SmsQuotaExceededException(__('Your SMS balance has run out.'));
    }
}
