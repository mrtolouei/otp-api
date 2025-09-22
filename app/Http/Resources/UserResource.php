<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'mobile' => $this->resource->mobile,
            'firstname' => $this->resource->firstname,
            'lastname' => $this->resource->lastname,
            'national_id' => $this->resource->national_id,
            'birthdate' => $this->resource->birthdate,
            'subscription' => SubscriptionResource::make($this->resource->subscription),
            'roles' => RoleResource::collection($this->resource->roles),
            'created_at' => $this->resource->created_at,
        ];
    }
}
