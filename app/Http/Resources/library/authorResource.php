<?php

namespace App\Http\Resources\library;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class authorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'books' => bookResource::collection($this->whenLoaded('books'))
        ];
    }
}
