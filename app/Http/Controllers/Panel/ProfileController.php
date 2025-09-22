<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index(Request $request): UserResource
    {
        return UserResource::make(
            $request->user('sanctum'),
        );
    }

    public function store(StoreProfileRequest $request): UserResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $request->user('sanctum');
            $user->update($request->validated());
            $user->refresh();
            DB::commit();
            return UserResource::make($user);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
