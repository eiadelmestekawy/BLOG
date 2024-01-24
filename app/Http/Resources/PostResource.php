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
            'id' => $this->id,
            'image' => asset($this->image),
            'created_at' => $this->created_at->format('Y-M-D'),
            'title' => $this->title,
            'smalldesc' => $this->smalldesc,
            'content' => $this->content,
            'blog' => $this->smalldesc . $this->content,
            'writer' => $this->whenLoaded('user'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ];
    }
}
