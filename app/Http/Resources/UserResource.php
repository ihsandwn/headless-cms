<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Only return public-safe information.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
        ];
    }
}