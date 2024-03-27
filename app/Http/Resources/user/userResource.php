<?php

namespace App\Http\Resources\user;

use App\Http\Resources\library\bookResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'books' => bookResource::collection($this->whenLoaded('books')),
            'token' => $this->token
        ];
    }
}
