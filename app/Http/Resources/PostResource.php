<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            // For performance, ensure the image URL is absolute and optimized.
            // Using asset() helper assumes the image is in the public disk.
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at->toIso8601String(),
            'author' => new UserResource($this->whenLoaded('user')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}