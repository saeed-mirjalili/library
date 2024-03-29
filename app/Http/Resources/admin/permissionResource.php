<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class permissionResource extends JsonResource
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
            'display_name' => $this->display_name,
            'roles' => roleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
