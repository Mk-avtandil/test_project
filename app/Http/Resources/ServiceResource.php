<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'orderable_type' => "Service",
            'price' => $this->price,
            'deadline' => $this->deadline,
            'example_link' => $this->example_link,
            'comments' => $this->comments,
        ];
    }
}
