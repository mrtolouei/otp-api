<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreUserRequest;
use App\Http\Requests\Panel\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(
            User::query()->latest('id')->paginate(request()->perPage ?? self::perPage),
        );
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    public function store(StoreUserRequest $request): UserResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = User::query()->create($request->validated());
            DB::commit();
            return UserResource::make($user);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateUserRequest $request, User $user): UserResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $user->update($request->validated());
            DB::commit();
            return UserResource::make($user);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $user): JsonResponse|Response
    {
        try {
            $user->delete();
            return response()->noContent();
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
