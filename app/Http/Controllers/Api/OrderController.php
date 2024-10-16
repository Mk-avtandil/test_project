<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{
    public function store(OrderCreateRequest $request): JsonResponse
    {
        $orderable = ($request->orderable_type)::findOrFail($request->orderable_id);


        $request['user_id'] = auth()->id();
        $order = $orderable->orders()->create($request);

        if ($orderable instanceof Product) {
            $orderable->quantity-=$request->quantity;
        }
        $orderable->save();

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order, 'orderable' => $orderable], 201);
    }


    public function show(Request $request): OrderCollection|JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)
            ->with('orderable', 'user')
            ->get();

        return new OrderCollection($orders);
    }
}
