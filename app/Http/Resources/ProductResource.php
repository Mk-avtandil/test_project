<?php

namespace App\Http\Resources;

use App\Models\Product;
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
            'orderable_type' => "product",
            'color' => $this->color,
            'size' => $this->size,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'cover' => $this->image('cover', 'default') ?: null,
            'comments' => $this->comments,
            'medias' => $this->medias
        ];
    }
}
