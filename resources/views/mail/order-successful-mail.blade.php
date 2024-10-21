<style>
    td {
        padding: 5px;
    }
</style>
<div>
    <h1>Dear, {{$user->name}}</h1>
    <p>You have successfully ordered <a href="{{route('product.show', ['product' => $order->orderable])}}">{{$order->orderable->type}}</a></p>
    <br>
    <table style="padding: 20px">
        <thead>
            <tr>
                <td>Quantity</td>
                <td>Price</td>
                <td>Sum</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$order->orderable->price}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->quantity * $order->orderable->price}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>

                <td colspan="2">Total:</td>
                <td>{{$order->quantity * $order->orderable->price}}</td>
            </tr>
        </tfoot>
    </table>

    <strong>Thanks,<br>{{ config('app.name') }}</strong>

</div>
