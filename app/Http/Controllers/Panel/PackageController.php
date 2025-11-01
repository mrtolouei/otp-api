<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PackageController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PlanResource::collection(
            Plan::query()->where('is_active', true)->latest('id')->get()
        );
    }

    public function show(string $uuid): PlanResource
    {
        $package = Plan::query()
            ->where('is_active', true)
            ->where('uuid', $uuid)
            ->firstOrFail();
        $gateways = collect(config('gateways.providers', []))
            ->map(function ($gateway) {
                $gateway['logo'] = url('api/dl?path=' . $gateway['logo']);
                return $gateway;
            });
        return PlanResource::make($package)->additional([
            'gateways' => $gateways,
        ]);
    }
}
