<?php

namespace App\Http\Resources\library;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class bookResource extends JsonResource
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
            'summary' => $this->summary,
            'edition' => $this->edition,
            'book_url' => url(env('BOOKS_PDF_SAVED_PATH').$this->book_url),
            'author' => new authorResource($this->whenLoaded('author')),
            'category' => new categoryResource($this->whenLoaded('category'))
        ];
    }
}
