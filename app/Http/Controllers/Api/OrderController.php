<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Product;
use App\Models\Service;


class OrderController extends Controller
{
    public function store(OrderCreateRequest $request)
    {
        $modelClass = $request->orderable_type === 'products' ? Product::class : Service::class;

        $orderable = $modelClass::findOrFail($request->orderable_id);

        $order = $orderable->orders()->create([
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order], 201);
    }
}
