<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class RecordOrderDetails
{
    public function handle(OrderPlaced $event)
    {
        $user = $event->order->user;
        $orderId = $event->order->id;
        $order = Order::with('orderables')->find($orderId);


        foreach ($order->orderables as $orderable) {
            $orderableModel = $orderable->orderable;

            DB::table('revisions')->insert([
                'username' => $order->user->name,
                'email' => $order->user->email,
                'user_ip' => request()->ip(),
                'device_name' => $this->getDeviceName(),
                'product_name' => $orderableModel->type,
                'quantity' => $orderable->quantity,
                'status' => $order->status,
                'price' => $orderableModel->price,
                'total_price' => ($orderable->quantity ?? 1) * $orderableModel->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    protected function getDeviceName()
    {
        $userAgent = request()->header('User-Agent');
        return $userAgent;
    }
}
