<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Mail\OrderSuccessfulMail;
use App\Models\Order;
use App\Models\Orderable;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(OrderCreateRequest $request): JsonResponse
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => $request['status'],
        ]);

        $createdOrderables = [];

        foreach ($request->orderables as $orderableData) {
            $orderableClass = Relation::getMorphedModel($orderableData['orderable_type']);
            $orderable = $orderableClass::find($orderableData['orderable_id']);

            if (!$orderable) {
                return response()->json(['message' => 'Product or Service not found'], 404);
            }

            if ($orderable instanceof Product) {
                if ($orderable->quantity < $orderableData['quantity']) {
                    return response()->json(['message' => 'Not enough quantity available for product ' . $orderable->type], 400);
                }

                $orderable->quantity -= $orderableData['quantity'];
                $orderable->save();
            }

            $orderableEntry = Orderable::create([
                'order_id' => $order->id,
                'orderable_id' => $orderableData['orderable_id'],
                'orderable_type' => $orderableData['orderable_type'],
                'quantity' => $orderableData['quantity'],
            ]);

            $createdOrderables[] = $orderableEntry;
        }
        Mail::to(auth()->user())->send(new OrderSuccessfulMail(auth()->user(), $order));

        return response()->json(['message' => 'Заказ успешно создан'], 201);
    }

    public function index(): OrderCollection|JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)->with('orderables.orderable')->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found.'], 404);
        }

        return new OrderCollection($orders);
    }

    public function update(OrderUpdateRequest $request, Order $order): JsonResponse
    {
        $order->update([
            'status' => $request->get('status'),
        ]);

        return response()->json(['order' => $order]);
    }
}
