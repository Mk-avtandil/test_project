<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{
    public function store(OrderCreateRequest $request)
    {
        $modelClass = $request->orderable_type === 'App\\Models\\Product' ? Product::class : Service::class;

        $orderable = $modelClass::findOrFail($request->orderable_id);

        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $order = $orderable->orders()->create($validated);


        if ($orderable instanceof Product) {
            $orderable->quantity-=$request->quantity;
        }

        $orderable->save();

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order, 'orderable' => $orderable], 201);
    }


    public function show(Request $request)
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
