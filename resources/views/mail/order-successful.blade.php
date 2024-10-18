<x-mail::message>
# Dear, {{$user->name}}

You have successfully ordered {{$order->orderable->type}}
    - Quantity: {{$order->quantity}}
    - Total Price: {{$order->quantity * $order->orderable->price }}
<x-mail::button :url="'{{$order_link}}'">
Click to view
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
