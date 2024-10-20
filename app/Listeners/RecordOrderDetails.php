<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\DB;

class RecordOrderDetails
{
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
        $user = $order->user;
        $orderable = $order->orderable;

        DB::table('order_records')->insert([
            'username' => $user->name,
            'email' => $user->email,
            'user_ip' => request()->ip(),
            'device_name' => $this->getDeviceName(),
            'product_name' => $orderable->type,
            'quantity' => $order->quantity,
            'status' => $order->status,
            'price' => $orderable->price,
            'total_price' => $order->quantity * $orderable->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function getDeviceName()
    {
        $userAgent = request()->header('User-Agent');
        return $userAgent;
    }
}
