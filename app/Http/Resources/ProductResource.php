<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => $this->type,
            'color' => $this->color,
            'size' => $this->size,
            'price' => $this->price,
            'is_in_stock' => $this->is_in_stock,
            'description' => $this->description,
            'cover' => $this->image('cover', 'default') ?: null,
        ];
    }
}
