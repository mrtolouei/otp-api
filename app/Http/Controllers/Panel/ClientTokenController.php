<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\StoreClientTokenRequest;
use App\Http\Requests\Panel\UpdateClientTokenRequest;
use App\Http\Resources\ClientTokenResource;
use App\Models\ClientToken;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientTokenController extends Controller
{
    private int $userId;

    public function __construct()
    {
        $this->userId = request()->user()->id;
    }

    public function index(): AnonymousResourceCollection
    {
        return ClientTokenResource::collection(
            ClientToken::filters()->where('user_id', $this->userId)->get()
        );
    }

    public function show(int $id): ClientTokenResource
    {
        return ClientTokenResource::make(
            ClientToken::query()->where('user_id', $this->userId)->findOrFail($id)
        );
    }

    public function store(StoreClientTokenRequest $request): ClientTokenResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = User::with(['subscription'])->where('id', $this->userId)->first();
            if (!$user->subscription || $user->subscription->token_remaining < 1) {
                return response()->json([
                    'message' => __('You have no remaining Token credits.')
                ], 400);
            }
            $clientToken = ClientToken::query()->create([
                'user_id' => $this->userId,
                'sender_name' => $request->input('sender_name'),
                'status' => $request->input('status'),
                'token' => md5(Str::uuid()->toString()),
            ]);
            $user->subscription->decrement('token_remaining');
            DB::commit();
            return ClientTokenResource::make($clientToken);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function update(UpdateClientTokenRequest $request, int $id): ClientTokenResource|JsonResponse
    {
        try {
            DB::beginTransaction();
            $clientToken = ClientToken::query()->where('user_id', $this->userId)->findOrFail($id);
            $clientToken->update([
                'sender_name' => $request->input('sender_name'),
                'status' => $request->input('status'),
            ]);
            $clientToken->refresh();
            DB::commit();
            return ClientTokenResource::make($clientToken);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): Response|JsonResponse
    {
        try {
            $clientToken = ClientToken::query()->where('user_id', $this->userId)->findOrFail($id);
            $clientToken->delete();
            $user = User::with(['subscription'])->where('id', $this->userId)->first();
            $user->subscription->increment('token_remaining');
            return response()->noContent();
        } catch (Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }
}
