<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'token_quota' => $this->resource->token_quota,
            'sms_quota' => $this->resource->sms_quota,
            'voice_quota' => $this->resource->voice_quota,
            'months_duration' => $this->resource->months_duration,
            'price' => $this->resource->price,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at,
        ];
    }
}
