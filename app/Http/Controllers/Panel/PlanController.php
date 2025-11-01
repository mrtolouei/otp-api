<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StorePlanRequest;
use App\Http\Requests\Panel\UpdatePlanRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PlanResource::collection(
            Plan::filters()->latest('id')->paginate(request()->perPage ?? self::perPage),
        );
    }

    public function show(Plan $plan): PlanResource
    {
        return PlanResource::make($plan);
    }

    public function store(StorePlanRequest $request): PlanResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $data['uuid'] = Str::uuid()->toString();
            $plan = Plan::query()->create($data);
            DB::commit();
            return PlanResource::make($plan);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function update(UpdatePlanRequest $request, Plan $plan): PlanResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $plan->update($request->validated());
            $plan->refresh();
            DB::commit();
            return PlanResource::make($plan);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(Plan $plan): Response|JsonResponse
    {
        try {
            if ($plan->subscriptions()->count()) {
                return response()->json([
                    'message' => __('Cannot delete item.'),
                ], 400);
            }
            $plan->delete();
            return response()->noContent();
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function available(): AnonymousResourceCollection
    {
        return PlanResource::collection(
            Plan::query()->where('is_active', true)->latest('id')->get()
        );
    }
}
