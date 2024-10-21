<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Mail\OrderSuccessfulMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(OrderCreateRequest $request): JsonResponse
    {
        $orderable = ($request->orderable_type)::findOrFail($request->orderable_id);

        $request['user_id'] = auth()->id();
        $order = $orderable->orders()->create($request->all());

        if ($orderable instanceof Product) {
            $orderable->quantity-=$request->quantity;
        }
        $orderable->save();

        Mail::to(auth()->user())->send(new OrderSuccessfulMail(auth()->user(), $order));

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order, 'orderable' => $orderable], 201);
    }

    public function index(): OrderCollection|JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)->with('orderable', 'user')->get();

        return new OrderCollection($orders);
    }

    public function show(Order $order): OrderResource
    {
        return new OrderResource(Order::find($order->id));
    }

    public function update(OrderUpdateRequest $request, Order $order): JsonResponse
    {
        $order->update([
            'status' => $request->get('status'),
        ]);

        return response()->json(['order' => $order]);
    }
}
