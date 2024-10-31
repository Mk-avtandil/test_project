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
        $totalPrice = $this->orderables->reduce(function ($sum, $orderable) {
            $orderableModel = $orderable->orderable;

            if ($orderable->orderable_type === "product") {
                return $sum + ($orderable->quantity * $orderableModel->price);
            } elseif ($orderable->orderable_type === "service") {
                return $sum + $orderableModel->price;
            }

            return $sum;
        }, 0);

        return [
            'order' => [
                'status' => $this->status,
                'user_id' => $this->user_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'total_price' => $totalPrice,
            ],

            'orderables' => $this->orderables->map(function ($orderable) {
                $orderableModel = $orderable->orderable;

                $result = [
                    'type' => $orderableModel->type,
                    'price' => $orderableModel->price,
                ];

                if ($orderable->orderable_type === "product") {
                    $result['quantity'] = $orderable->quantity;
                    $result['color'] = $orderableModel->color;
                    $result['size'] = $orderableModel->size;
                    $result['description'] = $orderableModel->description;
                } elseif ($orderable->orderable_type === "service") {
                    $result['deadline'] = $orderableModel->deadline;
                    $result['example_link'] = $orderableModel->example_link;
                }

                return $result;
            }),
        ];
    }
}
