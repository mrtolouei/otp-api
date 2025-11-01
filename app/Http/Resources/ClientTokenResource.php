<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientTokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'signature' => $this->resource->signature,
            'token' => $this->resource->token,
            'is_active' => $this->resource->is_active,
            'last_used_at' => $this->resource->lastUsed->created_at ?? '',
            'created_at' => $this->resource->created_at,
        ];
    }
}
