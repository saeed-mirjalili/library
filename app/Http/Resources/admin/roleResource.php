<?php

namespace App\Http\Resources\admin;

use App\Http\Resources\user\userResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class roleResource extends JsonResource
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
            'users' => userResource::collection($this->whenLoaded('users')),
            'permissions' => permissionResource::collection($this->whenLoaded('permissions')),
        ];
    }
}
