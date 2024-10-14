<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'productOrServiceType' => $this->orderable_type,
            'productOrService' => $this->orderable,
            'quantity' => $this->quantity,
            'status' => $this->status
        ];
    }
}
