<style rel="text/css">
    .styled-table td {
        width: 30px;
    }
</style>
<div>
    <h4>Dear, {{$user->name}}</h4>
    <p>You have successfully ordered <a href="{{route('product.show', ['product' => $order->orderable])}}">{{$order->orderable->type}}</a></p>
    <br>
    <table class="styled-table">
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
