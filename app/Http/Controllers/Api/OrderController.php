<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Product;
use App\Models\Service;
use Closure;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function store(OrderCreateRequest $request)
    {
        $modelClass = $request->orderable_type === 'App\\Models\\Product' ? Product::class : Service::class;

        $orderable = $modelClass::findOrFail($request->orderable_id);
        $validator = Validator::make($request->all(), [
            'quantity' => [
                'required',
                'integer',
                function (string $attribute, mixed $value, Closure $fail) use ($orderable) {
                    if ($value > $orderable->quantity) {
                        $fail("The {$attribute} is greater than product quantity.");
                    }
                },
            ],
        ]);
        $validated = $validator->validated();
        $validated['user_id'] = 1; // TODO:: needs to be changed when authorization works

        $order = $orderable->orders()->create($validated);

        if ($orderable instanceof Product) {
            $orderable->quantity-=$request->quantity;
        }

        $orderable->save();

        return response()->json(['message' => 'Заказ успешно создан', 'order' => $order, 'orderable' => $orderable], 201);
    }
}
